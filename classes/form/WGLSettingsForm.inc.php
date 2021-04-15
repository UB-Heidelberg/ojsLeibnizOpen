<?php

/**
 * @file plugins/oaiMetadataFormats/dcwgl/WGLSettingsForm.inc.php
 *
 * Distributed under the GNU GPL v3

 */

import('lib.pkp.classes.form.Form');

/**
 * Class WGLSettingsForm
 */
class WGLSettingsForm extends Form
{

	/**
	 * WGLSettingsForm constructor.
	 * @param $plugin
	 */
	/***	 * @var context	 */
	private $_contextId;
	// var $contextId;

	/**
	 * @return context
	 */
	function _getContextId() {
		return $this->_contextId;
	}
	/** @var DOIPubIdPlugin */
	var $_plugin;

	/**
	 * Get the plugin.
	 * @return DOIPubIdPlugin
	 */
	function _getPlugin() {
		return $this->_plugin;
	}


	function __construct($plugin, $contextId) {
		//$this->_contextId = $contextId;
		$this->_plugin = $plugin;

                parent::__construct(method_exists($plugin, 'getTemplateResource') ? $plugin->getTemplateResource('WGLSettingsForm.tpl') : $plugin->getTemplatePath() . 'WGLSettingsForm.tpl');

		//parent::__construct($plugin->getTemplateResource('WGLSettingsForm.tpl'));
		$this->setData('pluginName', $plugin->getName());

		//$this->addCheck(new FormValidator($this, 'wgllist', 'required', 'plugins.oaiMetadataFormats.wgl.settings.list');
		//$this->addCheck(new FormValidator($this, 'wgllist', 'required', 'plugins.oaiMetadataFormats.settings.heiViewerEditionServiceURLRequired'));
                //$this->addCheck(new FormValidator($this, 'heiViewerEditionID', 'required', 'plugins.generic.heiViewerGalley.settings.heiViewerEditionIDRequired'));
	}

	/**
         * @copydoc Form::initData()
         */
        function initData() {
                /*foreach($this->_getFormFields() as $fieldName => $fieldType) {
                        $fieldValue = $this->plugin->getSetting($this->contextId, $fieldName);
                        $this->setData($fieldName, $fieldValue);
                }*/
		$plugin = $this->_getPlugin();
                //$contextId =  $this->_getContextId();
                $context = Application::get()->getRequest()->getContext();
                $contextId =  $context->getId();
		$wglSettings = $plugin->getSetting($contextId, 'wglSettings');
                if (isset($wglSettings) & !empty($wglSettings)) {
                        $this->setData('wglSettings', $wglSettings);
                }
                else {
                        $this->setData('wglSettings', '');
                }
        }

        /**
         * @copydoc Form::fetch()
         */
        function fetch($request, $template = NULL, $display = false) {
                $templateMgr = TemplateManager::getManager($request);
                $plugin = $this->_getPlugin();
		$templateMgr->assign('pluginName', $plugin->getName());
		//$templateMgr->assign('pluginName', $this->plugin->getName());
                return parent::fetch($request);
        }

        /**
         * @copydoc Form::readInputData()
         */
        function readInputData() {
		//$this->readUserVars(array_keys($this->_getFormFields()));
		$this->readUserVars(array('wglSettings'));
        }

        /**
         * Save settings.
         */
        function execute() {
		/*foreach($this->_getFormFields() as $fieldName => $fieldType) {
			$this->plugin->updateSetting($this->contextId, $fieldName, $this->getData($fieldName), $fieldType);
		}*/
		$plugin = $this->_plugin;
                //$context = Request::getContext();
                //$contextId = $context ? $context->getId() : CONTEXT_ID_NONE;
                //$contextId =  $this->_getContextId();
		$context = Application::get()->getRequest()->getContext();
                $contextId =  $context->getId();
		$plugin->updateSetting($contextId, 'wglSettings', $this->getData('wglSettings'));
		}

        /**
         * Get all form fields and their types
         * @return array
         */
	 function _getFormFields() {
                return array(
			'list' => 'string',
                        /*'heiViewerEditionServiceURL' => 'string',
                        'heiViewerEditionID' => 'string',*/
                );
        }


	/*
	function initData()
	{
		$plugin = $this->_getPlugin();
		$contextId =  $this->_getContextId();
		$wglSettings = $plugin->getSetting($contextId, 'wglSettings');
		if (isset($wglSettings) & !empty($wglSettings)) {
			$this->setData('wglSettings', $wglSettings);
		}
		else {
			$this->setData('wglSettings', '');
		}
	}

	function readInputData()
	{
		$this->readUserVars(array('wglSettings'));
	}


	function execute()
	{
		$plugin = $this->_plugin;
		$context = Request::getContext();
		$contextId = $context ? $context->getId() : CONTEXT_ID_NONE;
		$plugin->updateSetting($contextId, 'wglSettings', $this->getData('wglSettings'));
	}
	*/

	/*function manage($args, $request) {
		$plugin = $this->getAuthorizedContextObject(ASSOC_TYPE_PLUGIN);
		return $plugin->manage($args, $request);
	}*/

	/*
	function fetch($request) {
		$templateMgr = TemplateManager::getManager($request);
		return parent::fetch($request);
	}
	*/
	
}
