<?php

namespace easyadmin\app\libs;

use easyadmin\app\libs\Template as TemplateAlias;
use think\Exception;
use think\Exception as ExceptionAlias;

/**
 * 按钮类
 * Class Btn
 * @package easyadmin\app\libs
 */
class Btn
{
    /**
     * @var string 按钮名称
     */
    private $label;

    /**
     * 按钮URL
     */
    private $url;

    /**
     * 按钮URL 参数
     * @var array
     */
    private $params = [];

    /**
     * @var array 按钮的样式列表
     */
    private $class = [];

    /**
     * @var string 按钮的图标
     */
    private $icon;

    /**
     * @var string 按钮的模板路径
     */
    private $template = 'public:btn';

    /**
     * 是否启用 调整
     *
     * 按钮执行完成以后 跳转到上一页
     * @var bool
     */
    private $referer = false;

    /**
     * 点击按钮是否需要确认
     * 文字为真, 需要确认,并且提示相关的文字
     * @var string
     */
    private $isConfirm = '';

    /**
     * 按钮类型
     * a:  a   素 a 标签
     * btn:  layui-button  a 标签 添加了 layui-button 样式
     * button:  button-button  button标签 type button
     * submit:  button-submit  button标签 type submit
     * @var string
     */
    private $btnType = 'btn';


    private $dataId;


    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }


    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param  $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function addParam($key, $val)
    {
        $this->params[$key] = $val;
    }

    /**
     * @return array
     */
    public function getClass(): array
    {
        return $this->class;
    }

    /**
     * @param $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    public function addClass($className)
    {
        array_push($this->class, $className);
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;
    }


    /**
     * 渲染页面的按钮
     * @return string
     * @throws ExceptionAlias
     */
    public function __toString(): string
    {

        $url = $this->getUrl();

        $params = $this->getParams();

        $url = Lib::formatUrl($url, $params);

        //模板路径
        $path = $this->getTemplate();

        $class = is_array($this->getClass()) ? implode(' ', $this->getClass()) : $this->getClass();

        $data = [
            'url' => $url,
            'class' => $class,
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'confirmText' => $this->getIsConfirm(),
            'btnType' => $this->getBtnType(),
            'dataId'=>$this->getDataId()
        ];

        if ($this->isReferer()) {
            $data['referer'] = request()->server('HTTP_REFERER');
        } else {
            $data['referer'] = '';
        }

        //渲染
        $template = new TemplateAlias();
        $template->fetch($path, $data);
        return '';
    }

    /**
     * @return string
     */
    public function getIsConfirm(): string
    {
        return $this->isConfirm;
    }

    /**
     * @param string $isConfirm
     */
    public function setIsConfirm(string $isConfirm)
    {
        $this->isConfirm = $isConfirm;
    }

    /**
     * @return string
     */
    public function getBtnType(): string
    {
        return $this->btnType;
    }

    /**
     * @param string $btnType
     * @return $this
     * @throws ExceptionAlias
     */
    public function setBtnType(string $btnType): Btn
    {
        $types = ['a', 'btn', 'submit', 'button'];
        if (!in_array($btnType, $types)) {
            throw new Exception('按钮类型错误');
        }
        $this->btnType = $btnType;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReferer(): bool
    {
        return $this->referer;
    }

    /**
     * @param bool $referer
     */
    public function setReferer(bool $referer): void
    {
        $this->referer = $referer;
    }

    /**
     * @param mixed $dataId
     * @return Btn
     */
    public function setDataId($dataId)
    {
        $this->dataId = $dataId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataId()
    {
        return $this->dataId;
    }


}
