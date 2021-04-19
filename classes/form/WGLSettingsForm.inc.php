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
		$this->_plugin = $plugin;
                parent::__construct(method_exists($plugin, 'getTemplateResource') ? $plugin->getTemplateResource('WGLSettingsForm.tpl') : $plugin->getTemplatePath() . 'WGLSettingsForm.tpl');
		$this->setData('pluginName', $plugin->getName());
	}

	/**
         * @copydoc Form::initData()
         */
        function initData() {
		$plugin = $this->_getPlugin();
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
                return parent::fetch($request);
        }

        /**
         * @copydoc Form::readInputData()
         */
        function readInputData() {
		$this->readUserVars(array('wglSettings'));
        }

        /**
         * Save settings.
         */
        function execute() {
		$plugin = $this->_plugin;
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
		);
        }
}
