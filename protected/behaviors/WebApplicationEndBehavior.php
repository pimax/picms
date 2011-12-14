<?php

class WebApplicationEndBehavior extends CBehavior 
{

    // имя нужной нам части сайта
    private $_endName;

    // геттер $_endName;
    public function getEndName() 
    {
        return $this->_endName;
    }

    // запуск приложения
    public function runEnd($name) 
    {
        $this->_endName = $name;

        // обрабатываем событие создания модуля
        $this->onModuleCreate = array($this, 'changeModulePaths');
        $this->onModuleCreate(new CEvent($this->owner));
        
        $this->owner->run();
    }

    // обработчик события onModuleCreate
    public function onModuleCreate($event) 
    {
        $this->raiseEvent('onModuleCreate', $event);
    }

    // подменяем пути к файлам
    protected function changeModulePaths($event) 
    {
        // добавляем название части сайта (frontend или backend) в путь, по которому фреймворк будет искать контроллеры и вьюшки
        $event->sender->controllerPath .= DIRECTORY_SEPARATOR . $this->_endName;
        $event->sender->viewPath .= DIRECTORY_SEPARATOR . $this->_endName;
    }

}