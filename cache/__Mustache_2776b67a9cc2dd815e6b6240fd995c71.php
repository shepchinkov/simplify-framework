<?php

class __Mustache_2776b67a9cc2dd815e6b6240fd995c71 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . 'My name is ';
        $value = $this->resolveValue($context->find('name'), $context);
        $buffer .= ($value === null ? '' : htmlspecialchars($value, 3, 'UTF-8'));

        return $buffer;
    }
}
