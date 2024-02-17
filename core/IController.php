<?php

namespace Core;

interface IController
{
    function setData($data);
    function init();
    function render();
}