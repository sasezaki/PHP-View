<?php

namespace SlimBench\Views;

use Athletic\AthleticEvent;
use Slim\Views\PhpRenderer;

class PhpRendererBench extends AthleticEvent
{
    public function classSetup()
    {
        $prophet = new \Prophecy\Prophet;
        $stream = $prophet->prophesize('Psr\\Http\\Message\\StreamInterface');
        $response = $prophet->prophesize('Psr\\Http\\Message\\Responseinterface');
        $response->getBody()->willReturn($stream);

        $dir = sys_get_temp_dir();
        $this->view = new PhpRenderer($dir);
        $template = tempnam($dir, 'slimbench');
        touch($template);
        $this->template = '/'.pathinfo($template, PATHINFO_FILENAME);
        $this->response = $response->reveal();
    }

    /**
     * @iterations 5000
     */
    public function render()
    {
        $view = $this->view;
        $view->render($this->response,$this->template);
    }
    
}

