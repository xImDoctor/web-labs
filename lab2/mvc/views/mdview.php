<?php
declare(strict_types=1);

namespace MVC\Views;

class MdView extends ViewFactory
{
    const LAYOUT = <<<MARKDOWN
# {{{title}}}

{{{body}}}

---
MARKDOWN;

    protected $replacements;

    public function __construct(object $decorator)
    {
        $body = method_exists($decorator, 'bodyMd') ? $decorator->bodyMd() : $decorator->body();


        $this->replacements = [
            '{{{title}}}' => $decorator->title(),
            '{{{body}}}' => $body
        ];
    }

    public function render() : string
    {
        return str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            self::LAYOUT
        );
    }


}