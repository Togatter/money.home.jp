<?php echo $year;?>年の振込情報
------------------------------

<?php 
$year_total_price = 0;
foreach ($transfer_histories as $transfer_history){
  $transfer_date  = $transfer_history['TTransferHistory']['transfer_day'];
  $transfer_price = $transfer_history['TTransferHistory']['transfer_price'];

  printf("%s  %10s円\n", $transfer_date, number_format($transfer_price));
  $year_total_price = $year_total_price + $transfer_price;
}; 

printf("\n合計金額%10s円\n", number_format($year_total_price));
?>


サマリ情報
------------------------------
<?php
printf("%10s %10s円\n","振込目標額", $total_price);
printf("%10s %10s円\n","合計振込額", $total_transfer_price);
printf("%10s %10s円\n","振込残高", $remaining_price);
?>


==============================
FROM: Masaya Toga
==============================
