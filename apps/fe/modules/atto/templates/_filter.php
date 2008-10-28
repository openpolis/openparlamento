<h1>tipo: 
  <?php echo ( $this->getContext()->getActionName()=='ddlList' ? 'Disegni di legge' : link_to('Disegni di legge', 'atto/ddlList') ) ?>
  <?php echo ( $this->getContext()->getActionName()=='list' ? 'Atti non legislativi' : link_to('Atti non legislativi', 'atto/list') ) ?>
</h1>
<br />
<br />