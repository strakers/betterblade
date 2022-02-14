<?php

namespace BetterBlade;

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BetterBladeCompiler extends BladeCompiler {
	/**
	    * Evaluate and render a Blade string to HTML.
	    *
	    * @param  string  $string
	    * @param  array  $data
	    * @param  bool  $deleteCachedView
	    * @return string
	    */
	public static function render($string, $data = [], $deleteCachedView = false)
	{
	    $component = new class($string) extends Component
	    {
	        protected $template;
	
	        public function __construct($template)
	        {
	            $this->template = $template;
	        }
	
	        public function render()
	        {
	            return $this->template;
	        }
	    };
	
	    $view = Container::getInstance()
	                ->make(ViewFactory::class)
	                ->make($component->resolveView(), $data);
	
	    return tap($view->render(), function () use ($view, $deleteCachedView) {
	        if ($deleteCachedView) {
	            unlink($view->getPath());
	        }
	    });
	}
	
	/**
	    * Render a component instance to HTML.
	    *
	    * @param  \Illuminate\View\Component  $component
	    * @return string
	    */
	public static function renderComponent(Component $component)
	{
	    $data = $component->data();
	
	    $view = value($component->resolveView(), $data);
	
	    if ($view instanceof View) {
	        return $view->with($data)->render();
	    } elseif ($view instanceof Htmlable) {
	        return $view->toHtml();
	    } else {
	        return Container::getInstance()
	            ->make(ViewFactory::class)
	            ->make($view, $data)
	            ->render();
	    }
	}
}