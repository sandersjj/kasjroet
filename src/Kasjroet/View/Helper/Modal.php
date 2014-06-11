<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 6/2/14
 * Time: 9:47 PM
 */

namespace Kasjroet\View\Helper;
use Zend\View\Helper\AbstractHelper;

class Modal extends AbstractHelper
{
	protected $template = 'partial/modal';

	/**
	 * @param $template
	 */
	public function setTemplate($template)
	{
		$this->template = $template;
	}

	/**
	 * @return null|string
	 */
	public function getTemplate()
	{
		return isset($this->template) ? $this->template : null;
	}

	public function setOption($name, $value)
	{
		switch($name) {
			case 'template':
				$this->setTemplate($value);
				break;
			default:
				break;

		}
	}

	public function __invoke($title = null, $content, $target)
	{
		if (null !== $title) {
			return $this->render($title, $content, $target);
		}
		return $this;
	}

	public function render($title, $content, $target)
	{
		$partial = $this->getView()->plugin('partial');
		return $partial($this->template, array(
				'title'   => $title,
				'content' => $content,
				'target'  => $target
		));
	}

} 