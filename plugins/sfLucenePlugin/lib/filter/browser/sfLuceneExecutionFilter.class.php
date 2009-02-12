<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package sfLucenePlugin
 * @subpackage Filter
 * @author Carl Vondrick
 */
class sfLuceneExecutionFilter extends sfExecutionFilter
{
    /**
   * Executes this filter.
   *
   * @param sfFilterChain The filter chain
   *
   * @throws <b>sfInitializeException</b> If an error occurs during view initialization.
   * @throws <b>sfViewException</b>       If an error occurs while executing the view.
   */
  public function execute($filterChain)
  {
    // get the context and controller
    $context    = $this->getContext();
    $controller = $context->getController();

    // get the current action instance
    $actionEntry    = $controller->getActionStack()->getLastEntry();
    $actionInstance = $actionEntry->getActionInstance();

    // get the current action information
    $moduleName = $context->getModuleName();
    $actionName = $context->getActionName();

    // get the request method
    $method = $context->getRequest()->getMethod();

    $viewName = null;

    if (($actionInstance->getRequestMethods() & $method) != $method)
    {
      // this action will skip validation/execution for this method
      // get the default view
      $viewName = $actionInstance->getDefaultView();
    }
    else
    {
      // set default validated status
      $validated = true;

      // get the current action validation configuration
      $validationConfig = $moduleName.'/'.sfConfig::get('sf_app_module_validate_dir_name').'/'.$actionName.'.yml';

      // load validation configuration
      // do NOT use require_once
      if (null !== $validateFile = sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_module_dir_name').'/'.$validationConfig, true))
      {
        // create validator manager
        $validatorManager = new sfValidatorManager();
        $validatorManager->initialize($context);

        require($validateFile);

        // process validators
        $validated = $validatorManager->execute();
      }

      // process manual validation
      $validateToRun = 'validate'.ucfirst($actionName);
      $manualValidated = method_exists($actionInstance, $validateToRun) ? $actionInstance->$validateToRun() : $actionInstance->validate();

      // action is validated if:
      // - all validation methods (manual and automatic) return true
      // - or automatic validation returns false but errors have been 'removed' by manual validation
      $validated = ($manualValidated && $validated) || ($manualValidated && !$validated && !$context->getRequest()->hasErrors());

      // register fill-in filter
      if (null !== ($parameters = $context->getRequest()->getAttribute('fillin', null, 'symfony/filter')))
      {
        $this->registerFillInFilter($filterChain, $parameters);
      }

      if ($validated)
      {
        // execute the action
        $actionInstance->preExecute();
        $viewName = $actionInstance->execute();
        if ($viewName == '')
        {
          $viewName = sfView::SUCCESS;
        }
        $actionInstance->postExecute();
      }
      else
      {
        // validation failed
        $handleErrorToRun = 'handleError'.ucfirst($actionName);
        $viewName = method_exists($actionInstance, $handleErrorToRun) ? $actionInstance->$handleErrorToRun() : $actionInstance->handleError();
        if ($viewName == '')
        {
          $viewName = sfView::ERROR;
        }
      }
    }

    if ($viewName == sfView::HEADER_ONLY)
    {
      $context->getResponse()->setHeaderOnly(true);

      // execute next filter
      $filterChain->execute();
    }
    else if ($viewName != sfView::NONE)
    {
      $this->getContext()->getResponse()->setParameter(sprintf('%s_%s_layout', $moduleName, $actionName), $this->getParameter('layout', false), 'symfony/action/view');

      // get the view instance
      $viewInstance = $controller->getView($moduleName, $actionName, $viewName);

      $viewInstance->initialize($context, $moduleName, $actionName, $viewName);

      $viewInstance->execute();

      // render the view and if data is returned, stick it in the
      // action entry which was retrieved from the execution chain
      $viewData = $viewInstance->render();

      if ($controller->getRenderMode() == sfView::RENDER_VAR)
      {
        $actionEntry->setPresentation($viewData);
      }
      else
      {
        // execute next filter
        $filterChain->execute();
      }
    }
  }
}