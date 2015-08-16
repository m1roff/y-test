<link rel="stylesheet" href="/vendor/highlight/styles/default.css">
<script src="/vendor/highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<pre><code class="sql">
SELECT  `d`.`type` , `d`.`value` FROM `data` AS d
INNER JOIN 
    (SELECT `d2`.`id`, max(`d2`.`date`) 'maxdate', `d2`.`type` FROM `data` d2 GROUP BY `d2`.`type`) AS ddate
    ON ( `ddate`.`type` = `d`.`type` AND `ddate`.`maxdate`=`d`.`date` )
</code></pre>