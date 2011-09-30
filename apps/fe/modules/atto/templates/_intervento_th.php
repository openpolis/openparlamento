<tr>
  <th scope="col"><br />data:</th>
  <th scope="col"><br />sede:</th>
  <th scope="col">intervento di:</th>
  <th scope="col">link al testo:</th>
  <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
    <th scope="col">parere utenti:</th>  
    <th scope="col">il tuo parere:</th>
  <?php endif ?>
</tr>
