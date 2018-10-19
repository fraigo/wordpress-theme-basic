<?php if (!is_array($echo) || $echo["header"]!==false){ ?>
<h2 class="widget-title">Search</h2>
<?php } ?>
<form role="search" class="form-inline flex-row mb-2" action="<?php echo esc_url( home_url() ); ?>">
  <div class="input-group">
    <input class="form-control" value="<?php echo get_query_var('s') ?>" type="text" name="s" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">🔍</button>
    </div>
  </div>
</form>
