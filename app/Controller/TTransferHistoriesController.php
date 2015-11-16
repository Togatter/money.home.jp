<?php


class TTransferHistoriesController extends AppController {

  public $uses      = array('TTransferHistory', 'MParameter');
  public $helpers   = array("Html", "Form");

  public function index() {

    // =============================================================================================
    // 初期化処理
    // =============================================================================================

    $this->set('title_for_layout', 'トップ');
    $regist = "";

    // 今年を取得
    $this_year = date('Y');
    $this->set('end_year', $this_year);
    
    // 振込開始年数を取得
    $start_year = $this->MParameter->find('first', array('conditions' => array('parameter_name' => "start_year")));
    $this->set("start_year", $start_year["MParameter"]["parameter_value"]);



    // =============================================================================================
    // POST処理
    // =============================================================================================

    if ($this->request->data) {
      $transfer_price  = $this->request->data['TTransferHistory']['transfer_price'];
      $transfer_year   = $this->request->data['TTransferHistory']['transfer_day']['year'];
      $transfer_month  = $this->request->data['TTransferHistory']['transfer_day']['month'];
      $transfer_day    = $this->request->data['TTransferHistory']['transfer_day']['day'];

      $data['TTransferHistory']['transfer_price'] = $transfer_price;
      $data['TTransferHistory']['transfer_day']   = $transfer_year."/".$transfer_month."/".$transfer_day;

      if($this->TTransferHistory->save($data)){
        $regist = "振込が完了致しました";
      }
    }



    // =============================================================================================
    // 合計振込額などのサマリ情報
    // =============================================================================================

    // 振込目標額を取得
    $total_price = $this->MParameter->find('first', array('conditions' => array('parameter_name' => "total_price")));
    $total_price = $total_price["MParameter"]["parameter_value"];
    $this->set("total_price", $total_price);

    // 振込合計額を取得
    $total_transfer_price = $this->TTransferHistory->find(
      'first', 
      array(
        'conditions' => array('deleted' => 1),
        'fields' => array('sum(transfer_price) as total_transfer_price')
      )
    );
    $total_transfer_price = $total_transfer_price[0]["total_transfer_price"];
    $this->set("total_transfer_price", $total_transfer_price);



    // =============================================================================================
    // 今年分の振込履歴情報
    // =============================================================================================

    // 今年分の振込履歴
    $transfer_histories = $this->TTransferHistory->findTransferHistory($this_year);
    $this->set("transfer_histories", $transfer_histories);



    // =============================================================================================
    // メール送信処理
    // =============================================================================================
    if ($this->request->data) {
      if($regist != ""){
        $remaining_price = $total_price - $total_transfer_price;
        $email   = new CakeEmail('admin');
        $email->to('1970emerson.lake.and.palmer@gmail.com');
        $email->subject($transfer_year."年".$transfer_month."月".$transfer_day."日 振込完了のお知らせ");
        $email->emailFormat('text');
        $email->template('transfer');
        $email->viewVars(array(
            'total_price'          => number_format(intval($total_price)), 
            'total_transfer_price' => number_format(intval($total_transfer_price)), 
            'transfer_year'        => $transfer_year, 
            'transfer_month'       => $transfer_month, 
            'transfer_day'         => $transfer_day, 
            'transfer_price'       => number_format(intval($transfer_price)),
            'remaining_price'      => number_format(intval($remaining_price))
          )
        );
        $email->send();
      }
    }
    $this->set('regist', $regist);
  }



  public function history($this_year) {

    $this->set('title_for_layout', $this_year.'年 - 振込履歴');
    $transfer_histories = $this->TTransferHistory->findTransferHistory($this_year);
    $this->set('transfer_histories', $transfer_histories);

  }
}
