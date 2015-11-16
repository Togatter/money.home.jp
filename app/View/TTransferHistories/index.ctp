<?php echo $regist; ?>
<table>
  <tr>
    <td>振込目標額</td>
    <td><?php echo number_format($total_price); ?>円</td>
  <tr>
  <tr>
    <td>振込合計額</td>
    <td><?php echo number_format($total_transfer_price); ?>円</td>

  <tr>
</table>


<?php echo $this->Form->Create('TTransferHistory', array('type'=>'post')); ?>

<table>
  <tr>
    <td>振込額(円)</td>
    <td>
      <?php 
        echo $this->Form->input('transfer_price', array(
          'label' => false
        )
      );?>
    </td>
  </tr>
  <tr>
    <td>振込日付</td>
    <td>
      <?php
        echo $this->Form->input('transfer_day', array(
          'label'      => false,
          'dateFormat' => 'YMD',
          'monthNames' => false,
          'minYear'    => date('Y') - 5,
          'maxYear'    => date('Y') + 1
          )
        )
      ?>
    </td>
  </tr>
</table>
<?php echo $this->Form->submit('振込む', array('onClick' => 'return confirm("振込みしてよろしいでしょうか")')); ?>


<?php echo $this->Form->end(); ?>

<table>
  <tr>
  <?php for ($i = 1; $i <= ($end_year - $start_year); $i++): ?>
  <?php if (($i % 5) != 0): ?>
    <td>
    <a href="TTransferHistories/history/<?php echo $start_year + $i - 1; ?>"><?php echo $start_year + $i - 1; ?>年</a>
    </td>
    
  <?php elseif (($i % 5) == 0): ?>

    <td>
      <a href="TTransferHistories/history/<?php echo $start_year + $i - 1; ?>"><?php echo $start_year + $i - 1; ?>年</a>
    </td>
  </tr>
  <tr>
  <?php endif; ?>
  <?php endfor; ?>
  </tr>
</table>
<table>
  <tr>
    <td>日付</td>
    <td>振込額</td>
  </tr>

  <?php foreach($transfer_histories as $transfer_history): ?>
  <tr>
    <td><?php echo $transfer_history["TTransferHistory"]["transfer_day"]; ?></td>
    <td><?php echo number_format($transfer_history["TTransferHistory"]["transfer_price"]); ?>円</td>
  </tr>
  <?php endforeach; ?>
</table>
