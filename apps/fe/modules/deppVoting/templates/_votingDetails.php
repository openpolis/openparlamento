<?php sfLoader::loadHelpers('I18N') ?>

<?php if (isset($object)): ?>

  <div id="total-votings" style="margin: 10px 0">
    <?php echo format_number_choice(
      '[0]Nessuno ha ancora votato|[1]Cos&igrave; ha votato <strong>un</strong> utente|(1,+Inf]Cos&igrave; hanno votato gli altri <strong>%1%</strong> utenti', array('%1%' => $total_votings), $total_votings) ?>    
  </div>

  <?php if ($total_votings): ?>

    <div id="vote-yes-results">
      <div class="vote-bar" style="width:<?php echo round($voting_details[1]['percent']) ?>%;">
        <?php echo round($voting_details[1]['percent']) ?>%
      </div>
    </div>
    <div class="vote-yes-more-results">
      <?php if ($voting_details[1]['count']): ?>
        <div  class="vote-yes-more-results">
          <?php echo format_number_choice(
            '[1]<strong>1</strong> utente favorevole ha|(1,+Inf]<strong>%1%</strong> favorevoli hanno', 
            array('%1%' => $voting_details[1]['count']), $voting_details[1]['count']) ?>
            <a href="#prousersdo" class="action">votato anche...</a>
        </div>
      <?php endif ?>
    </div>

    <div id="vote-no-results">
      <div class="vote-bar" style="width: <?php echo round($voting_details[-1]['percent']) ?>%;">
        <?php echo round($voting_details[-1]['percent']) ?>%
      </div>
    </div>
    <?php if ($voting_details[-1]['count']): ?>
      <div  class="vote-no-more-results">
        <?php echo format_number_choice(
          '[1]<strong>1</strong> utente contrario ha|(1,+Inf]<strong>%1%</strong> contrari hanno', 
          array('%1%' => $voting_details[-1]['count']), $voting_details[-1]['count']) ?>
          <a href="#antiusersdo" class="action">votato anche...</a>
      </div>
    <?php endif ?>

  <?php endif ?>

<?php endif; ?>

<div id="closing"></div>