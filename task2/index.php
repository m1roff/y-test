<link rel="stylesheet" href="/vendor/highlight/styles/default.css">
<script src="/vendor/highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<h3>Таблица всех авторов.</h3>
<pre>
    <code class="sql">
CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    </code>
</pre>

<h3>Таблица всех кних</h3>
<pre><code class="sql">
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
</code></pre>

<h3>Таблица связи авторов с книгами</h3>
<pre><code class="sql">
CREATE TABLE IF NOT EXISTS `cross_authors_books` (
  `id_books` int(10) unsigned NOT NULL,
  `id_authors` int(10) unsigned NOT NULL,
  KEY `id_books` (`id_books`),
  KEY `id_authors` (`id_authors`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
</code></pre>

<h3>Ограничения для кросс-таблицы</h3>
<pre><code class="sql">
ALTER TABLE `cross_authors_books`
  ADD CONSTRAINT `cross_authors_books_ibfk_2` FOREIGN KEY (`id_authors`) REFERENCES `authors` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cross_authors_books_ibfk_1` FOREIGN KEY (`id_books`) REFERENCES `books` (`id`) ON UPDATE CASCADE;
</code></pre>