<?php

include_once(dirname(__FILE__).'/aGraph.php');

/**
 * Класс для рисования квадрата с указанной длиной стороны
 */
class SquareGraph extends aGraph
{

    /**
     * @var int Размер квадрата
     */
    private $size;

    /**
     * Ограничение
     */
    const MIN_SIZE = 5;

    /**
     * Подготовка необходимых данных. Вызывается из {@link aGraph::show()}
     * @access protected
     * @return bool
     */
    protected function prepareParams()
    {
        if( !isset($this->params['size']) )
        {
            Graph::showErrorMessage('Fail: No defined size param.');
        }
        $this->size = (int)$this->params['size'];

        if( $this->size < self::MIN_SIZE )
        {
            Graph::showErrorMessage('Size must be more than '.self::MIN_SIZE.'.');
        }

        $this->image_weight = $this->image_height = $this->size+self::IMAGE_BORDER;

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
        return imagerectangle($this->image_resource, self::IMAGE_BORDER, self::IMAGE_BORDER, $this->size, $this->size, $this->getBorderColor());
    }
}