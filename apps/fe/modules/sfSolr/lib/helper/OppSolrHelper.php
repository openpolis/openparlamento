<?php
/*
 * This file is an addon to the sfSolrPlugin package
 * It contains variuos project specific helpers
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    openparlamento
 * @subpackage Helper
 * @author     Guglielmo Celata <g.celata@depp.it>
 */


function include_search_result_icon($result)
{
  $icon_types = array('OppPolitico'       => 'politico',
                      'OppDocumento'      => 'document',
                      'Tag'               => 'etichetta',
                      'OppEmendamento'    => 'attonoleg',
                      'OppVotazione'      => 'votazione',
                      'OppResoconto'        => 'descrizione',
                      );

  if ($result->sfl_model == 'OppAtto')
  {
    if (in_array($result->tipo_atto_id, array(1, 12, 15, 16, 17)))
      $icotype = 'proposta';
    else
      $icotype = 'attonoleg';
  } else
    $icotype = $icon_types[$result->sfl_model];

  echo image_tag('ico-type-' . $icotype.'.png', array('width' => '44', 'height' => '42'));
}

