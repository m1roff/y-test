<?php
/**
 * Абстрактный и базовый класс.
 * Вместе в одном файле - составляют одно целое.
 */

/**
 * Используется для вывода ошибок
 */
class Graph extends aGraph
{
    /**
     * @var string Сообщение для вывода
     */
    private $msg;

    /**
     * Подготовка необходимых данных. Вызывается из {@link aGraph::show()}
     * @access protected
     * @return bool
     */
    protected function prepareParams()
    {
        $messageLengs = mb_strlen($this->msg,'UTF-8');
        $this->image_height = 30;
        $this->image_weight = $messageLengs*9;
        return true;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * Инициализация конректной фигуры. 
     * Вызывается из {@link aGraph::show()}
     * @access protected
     * @return bool;
     */
    protected function setShape()
    {
        $textcolor = imagecolorallocate($this->image_resource, 255, 0, 0);
        return imagestring($this->image_resource, 5, 0, 0, $this->msg, $textcolor);
    }

    public static function showErrorMessage($msg)
    {
        $s = new self;
        $s->setMsg($msg);
        $s->show();
        die();
    }
}

abstract class aGraph
{
    /**
     * @var Array Хранилище для параметров.
     * Используется через геттер/сеттер
     * @access private
     */
    private $_params = array();

    /**
     * @var int Высота основного изображения
     * @access protected
     */
    protected $image_height;

    /**
     * @var int Ширина основного изображения
     * @access protected
     */
    protected $image_weight;

    /**
     * У потомков используется в {@link setShape()}
     * @var mixed Ресурс изображения или FALSE
     * @access protected
     */
    protected $image_resource;

    /**
     * @var int Используется для добавления "границы" к изображению
     */
    const IMAGE_BORDER = 10;

    /**
     * Цвет линии
     * Устанавливается в {@link setBorderColor()}
     * @var int Значение получение от imagecolorallocate()
     * @access private
     */
    private $color_border;

    /**
     * Цвет фона
     * Устанавливается в {@link setBackgroundColor()}
     * @var int Значение получение от imagecolorallocate()
     * @access private
     */
    private $color_background;

    /**
     * Параметры для установки цвета линии
     * По умолчанию: зеленый
     * @var Array 
     * @access private
     */
    private $color_borders_params=array(0,255,0);

    /**
     * Параметры для установки цвета фона
     * По умолчанию: светло-желтый
     * @var Array 
     * @access private
     */
    private $color_background_params=array(255,255,204);

    function __construct()
    {
        if ( !extension_loaded('gd') )
        {
            throw new Exception('У вас не установлена GD.');
        }
    }


    public function __set($name, $arg)
    {
        switch ( $name )
        {
            case 'params':
                if( !is_array($arg) )
                {
                    throw new Exception('Параметры должны быть переданы в виде массива.');
                }
                $this->_params = $arg;
            break;
        }
    }

    public function __get($name)
    {
        switch ( $name )
        {
            case 'params':
                return $this->_params;
        }
    }

    /**
     * Установка параметров для рисования фигуры
     * @abstract 
     * @access protected
     * @return bool
     */
    abstract protected function prepareParams();

    /**
     * Рисование конкретной фигуры
     * @abstract 
     * @access protected
     * @return bool
     */
    abstract protected function setShape();

    /**
     * Создание основы изображения в {@link image_resource}
     * Вызывается из {@link show()}
     * @access protected
     */
    protected function setImage()
    {
        // введем хоть какое-то ограничение
        $_miSize = self::IMAGE_BORDER*3;
        if( $this->image_weight < $_miSize || $this->image_height < $_miSize )
        {
            Graph::showErrorMessage('Height or Weight of shape have to be more than '.(self::IMAGE_BORDER*2).'.');
        }
        $this->image_resource = imagecreatetruecolor($this->image_weight, $this->image_height);
        if( $this->image_resource === false )
        {
            Graph::showErrorMessage('Can`t get image. GD not installed.');
        }
    }

    /**
     * Создание цвета линии
     * @access private
     */
    private function setBorderColor()
    {
        $this->color_border = imagecolorallocate($this->image_resource, $this->color_borders_params[0], $this->color_borders_params[1], $this->color_borders_params[2]);
    }

    /**
     * Создание цвета фона
     * @access private
     */
    private function setBackgroundColor()
    {
        $this->color_background = imagecolorallocate($this->image_resource, $this->color_background_params[0], $this->color_background_params[1], $this->color_background_params[2]);
    }

    /**
     * Сеттер
     * Установка цвета линии
     * @access protected
     */
    protected function setBorderColorParams($r,$g,$b)
    {
        $this->color_borders_params[0] = $r;
        $this->color_borders_params[1] = $g;
        $this->color_borders_params[2] = $b;
    }

    /**
     * Сеттер
     * Установка цвета фона
     * @access protected
     */
    protected function setBackgroundColorParams($r,$g,$b)
    {
        $this->color_background_params[0] = $r;
        $this->color_background_params[1] = $g;
        $this->color_background_params[2] = $b;
    }

    /**
     * Геттер
     * Получить цвет фона
     * @access protected
     */
    protected function getBackgroundColor()
    {
        return $this->color_background;
    }

    /**
     * Геттер
     * Получить цвет линии
     * @access protected
     */
    protected function getBorderColor()
    {
        return $this->color_border;
    }

    /**
     * Нарисовать фигуру
     * Выводит изображение сразу в поток броузера
     * @access public
     */
    public function show()
    {
        if( !$this->prepareParams() )
        {
            Graph::showErrorMessage('Prepare params of this shape failed.');
        }
        $this->setImage();
        $this->setBorderColor();
        $this->setBackgroundColor();

        imagefill($this->image_resource, 1, 1, $this->color_background);

        if( ! $this->setShape() )
        {
            Graph::showErrorMessage('Can`t draw this shape.');
        }

        header('Content-type: image/png');

        imagepng($this->image_resource);
        imagedestroy($this->image_resource);

    }
}