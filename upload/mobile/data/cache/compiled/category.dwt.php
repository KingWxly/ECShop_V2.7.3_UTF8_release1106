{includefile=library/page_header.lbi}
<div class="con">
  <div style="height:7.2em;"></div>
  <header>
    <nav class="ect-nav ect-bg icon-write"> {includefile=library/page_menu.lbi} </nav>
  </header>
  {includefile=library/goods_list.lbi} </div>
{includefile=library/search.lbi} {includefile=library/page_footer.lbi} 
<script type="text/javascript">
if( <?php echo $this->_var['show_asynclist']; ?> == 1){
 	get_asynclist('<?php echo url('category/asynclist', array('id'=>$this->_var['id'], 'brand'=>$this->_var['brand_id'], 'price_min'=>$this->_var['price_min'], 'price_max'=>$this->_var['price_max'], 'filter_attr'=>$this->_var['filter_attr'], 'page'=>$this->_var['page'], 'sort'=>$this->_var['sort'], 'order'=>$this->_var['order'], 'keywords'=>$this->_var['keywords']));?>' , '__TPL__/images/loader.gif');
 }
</script>
</body></html>