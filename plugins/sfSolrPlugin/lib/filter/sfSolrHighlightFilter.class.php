<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfSolrHighlightFilter automatically highlights the content according to the highlight parameter
 * and adds a notice to the user that the highlighting was preformed.
 *
 * Note: The highlight filter assumes valid X/HTML.  If it is not, unexpected highlighting may occur!
 *
 * @package sfSolrPlugin
 * @subpackage Filter
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author Carl Vondrick <carlv@carlsoft.net>
 */
class sfSolrHighlightFilter extends sfFilter
{
  /**
   * for unit tests only
   */
  protected $testMode = false;

  public function execute($filterChain)
  {
    $filterChain->execute();

    $response   = $this->getContext()->getResponse();
    $request    = $this->getContext()->getRequest();
    $controller = $this->getContext()->getController();

    // don't highlight:
    // * for XHR requests
    // * if 304
    // * if not rendering to the client
    // * if HTTP headers only
    if (
      $request->isXmlHttpRequest()                          ||
      strpos($response->getContentType(), 'html') === false ||
      $response->getStatusCode() == 304                     ||
      $controller->getRenderMode() != sfView::RENDER_CLIENT ||
      $response->isHeaderOnly()
    )
    {
      return;
    }

    $timer = sfTimerManager::getTimer('Highlight Filter');

    try
    {
      if (!$this->highlight())
      {
        $this->removeNotice();
      }
    }
    catch (sfSolrHighlighterException $e)
    {
      sfLogger::getInstance()->err('{sfSolrHighlightFilter} silently ignoring exception: ' . $e->getMessage());

      if ($this->testMode)
      {
        $timer->addTime();
        throw $e;
      }
    }
    catch (Exception $e)
    {
      $timer->addTime();
      throw $e;
    }

    $timer->addTime();
  }

  protected function highlight()
  {
    $terms = $this->getContext()->getRequest()->getParameter( $this->getHighlightQs() );
    $terms = $this->prepareTerms($terms);

    if (count($terms))
    {
      $this->addNotice($terms);
      $this->addCss();
      $this->doHighlight($terms);

      return true;
    }
    elseif ($this->shouldCheckReferer())
    {
      $referer = $this->getContext()->getRequest()->getReferer();

      if ($referer)
      {
        foreach ($this->getPossibleRefers() as $domain => $value)
        {
          if (preg_match($this->getRefererRegex($domain, $value['qs']), $referer, $matches))
          {
            $terms = $this->prepareTerms($matches[1]);

            $this->addNotice($terms, $value['name']);
            $this->addCss();
            $this->doHighlight($terms);

            return true;
          }
        }
      }
    }

    return false;
  }

  protected function doHighlight($terms)
  {
    $content = $this->getContext()->getResponse()->getContent();

    $lighter = new sfSolrHighlighter($content);
    $lighter->addKeywords($terms);
    $lighter->addHighlighters($this->getHighlightStrings());
    $lighter->hasBody(true);

    $this->getContext()->getResponse()->setContent($lighter->highlight());
  }

  protected function addCss()
  {
    $content = $this->getContext()->getResponse()->getContent();

    $css = $this->getCssLocation();

    if ($css && false !== ($pos = stripos($content, '</head>')))
    {

      sfLoader::loadHelpers(array('Tag', 'Asset'));

      $css = stylesheet_tag($css);

      $this->getContext()->getResponse()->setContent(substr($content, 0, $pos) . $css . substr($content, $pos));
    }
  }

  protected function prepareTerms($terms)
  {
    $terms = preg_split('/\W+/', trim($terms), -1, PREG_SPLIT_NO_EMPTY);

    $terms = array_unique($terms);

    return $terms;
  }

  protected function removeNotice()
  {
    $this->getContext()->getResponse()->setContent(
      str_replace($this->getNoticeTag(), '', $this->getContext()->getResponse()->getContent())
    );
  }

  protected function addNotice($terms, $from = null)
  {
    $content = $this->getContext()->getResponse()->getContent();

    $term_string = implode($terms, ', ');

    $route = $route = sfRouting::getInstance()->getCurrentInternalUri();
    $route = preg_replace('/(\?|&)' . $this->getHighlightQs() . '=.*?(&|$)/', '$1', $route);
    $route = $this->getContext()->getController()->genUrl($route);

    $remove_string = $this->translate($this->getRemoveString(), array('%url%' => $route));

    if ($from)
    {
      $message = $this->translate($this->getNoticeRefererString(), array('%from%' => $from, '%keywords%' => $term_string, '%remove%' => $remove_string));
    }
    else
    {
      $message = $this->translate($this->getNoticeString(), array('%keywords%' => $term_string, '%remove%' => $remove_string));
    }

    $content = str_replace($this->getNoticeTag(), $message, $content);

    $this->getContext()->getResponse()->setContent($content);
  }

  protected function translate($text, $args)
  {
    if ($this->getContext()->getI18N())
    {
      return $this->getContext()->getI18N()->__($text, $args, 'messages');
    }
    else
    {
      return str_replace(array_keys($args), array_values($args), $text);
    }
  }

  /* parameter getting items */

  protected function getPossibleRefers()
  {
    return array(
      'google'  => array('qs' => 'q', 'name' => 'Google'),
      'yahoo'   => array('qs' => 'p', 'name' => 'Yahoo'),
      'msn'     => array('qs' => 'q', 'name' => 'MSN'),
      'ask'     => array('qs' => 'q', 'name' => 'Ask')
    );
  }

  protected function getRefererRegex($domain, $qs)
  {
    $domain = preg_quote($domain, '#');
    $qs = preg_quote($qs, '#');

    return '#^https?://(?:\w+\.)*' . $domain . '(?:\.[a-z]+)+.*' . $qs . '=(.*?)(&|$)#';
  }

  protected function shouldCheckReferer()
  {
    return $this->getParameter('check_referer', true);
  }
  protected function getHighlightQs()
  {
    return sfConfig::get('app_solr_highlight_qs', $this->getParameter('highlight_qs', 'sf_highlight'));
  }
  protected function getNoticeTag()
  {
    return $this->getParameter('notice_tag', '<!--[HIGHLIGHTER_NOTICE]-->');
  }
  protected function getHighlightStrings()
  {
    $array = $this->getParameter('highlight_strings', array('<strong class="highlight hcolor1">%s</strong>', '<strong class="highlight hcolor2">%s</strong>', '<strong class="highlight hcolor3">%s</strong>', '<strong class="highlight hcolor4">%s</strong>', '<strong class="highlight hcolor5">%s</strong>'));

    return $array;
  }
  protected function getNoticeRefererString()
  {
    return $this->getParameter('notice_referer_string', '<div>Welcome from <strong>%from%</strong>!  The following keywords were automatically highlighted: %keywords% %remove%</div>');
  }
  protected function getNoticeString()
  {
    return $this->getParameter('notice_string', '<div>The following keywords were automatically highlighted: %keywords% %remove%</div>');
  }
  protected function getRemoveString()
  {
    return $this->getParameter('remove_string', '[<a href="%url%">remove highlighting</a>]');
  }

  protected function getCssLocation()
  {
    return $this->getParameter('css', '../sfSolrPlugin/css/search.css');
  }
}
