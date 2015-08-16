<?php

include_once(dirname(__FILE__).'/aGraph.php');

/**
 * Класс для рисования круга с указанным радиусом
 */
class CircleGraph extends aGraph
{
    /**
     * @var int Радиус круга
     * @access private
     */
    private $radius;

    /**
     * Ограничение минимального радиуса
     */
    const MIN_RADIUS = 5;

    /**
     * Подготовка необходимых данных. Вызывается из {@link aGraph::show()}
     * @access protected
     * @return bool
     */
    protected function prepareParams()
    {
        if( !isset($this->params['radius']) )
        {
            Graph::showErrorMessage('No defined Radius.');
        }
        $this->radius = (int)$this->params['radius'];
        if( $this->radius < self::MIN_RADIUS )
        {
            Graph::showErrorMessage('Radius must be more than '.self::MIN_RADIUS.'.');
        }

        $this->image_height = $this->radius + self::IMAGE_BORDER;
        $this->image_weight = $this->radius + self::IMAGE_BORDER;

        $this->setBackgroundColorParams(224, 224, 224);
        $this->setBorderColorParams(0, 0, 255);

        return true;
    }

    /**
     * Инициализация конректной фигуры. 
     * Вызывается из {@link aGraph::show()}
     * @access protected
     * @return bool;
     */
    protected function setShape()
    {
        return imageellipse($this->image_resource, $this->image_height/2, $this->image_weight/2, $this->radius, $this->radius, $this->getBorderColor());
    }
}