<?php
backend\assets\HighlightAsset::register($this);

?>

<pre>
    <code class="css">
        .hljs {
        display: block;
        overflow-x: auto;
        padding: 0.5em;
        background: #1d1f21;
        -webkit-text-size-adjust: none;
        }

        /*selection color*/
        .hljs::selection,
        .hljs span::selection {
        background: #373b41;
        }

        .hljs::-moz-selection,
        .hljs span::-moz-selection {
        background: #373b41;
        }

        /*foreground color*/
        .hljs,
        .hljs-setting .hljs-value,
        .hljs-expression .hljs-variable,
        .hljs-expression .hljs-begin-block,
        .hljs-expression .hljs-end-block,
        .hljs-class .hljs-params,
        .hljs-function .hljs-params,
        .hljs-at_rule .hljs-preprocessor {
        color: #c5c8c6;
        }
    </code>
</pre>

<script>hljs.initHighlightingOnLoad();</script>