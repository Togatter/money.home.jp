<html>
  <head></head>
  <body>
    <table>
      <tr>
        <td>日付</td>
        <td>振込額</td>
      </tr>

      <?php foreach($transfer_histories as $transfer_history): ?>
      <tr>
      <td><?php echo $transfer_history["TTransferHistory"]["transfer_day"]; ?></td>
        <td><?php echo $transfer_history["TTransferHistory"]["transfer_price"]; ?>円</td>
      </tr>
      <?php endforeach; ?>
    </table>

    <?php echo $this->Html->link('トップへ', '/'); ?>
  </body>
</html>
