<?php if($c->getLayout()): ?>
<script charset=utf-8 type="text/javascript">
//<![CDATA[
    document.addEventListener('DOMContentLoaded', function() {
      let css = document.createElement('link');
      css.rel = "stylesheet";
      css.href = "<?=$this->e($c->getLayout())?>.css";
      css.type = "text/css";
      css.media = "screen,projection,print";
      document.body.appendChild(css);
    });
//]]>
</script>
<?php endif; ?>