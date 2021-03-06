<?php
class Lottery{
    private $db;
    private $rands=array();
    private $bounds=array();
    public $current_contest=10;

    function __construct(){
        require_once ('MysqliDb.php');
        $cfg=include_once ('config.php');
        $this->db=new MysqliDb($cfg['host'],$cfg['username'],$cfg['password'],$cfg['dbname']);
    }

    function count_available_participants($contest){
        $this->db->where ("contest", $contest);
        $stats = $this->db->getOne ("participants", "count(*) as cnt");
        return $stats['cnt'];
    }

    function select_bound($contest,$type='first'){
        $this->db->orderBy("id",($type=='first')?'asc':'desc');
        $this->db->where ("contest", $contest);
        $first = $this->db->getOne('participants',array('id'));
        if ($this->db->count==1){
            return $first['id'];
        }else{return 1;}
    }

    function select_random($contest){
        #Create Bounds
        if(count($this->bounds)!=2){
            $this->bounds[]=$this->select_bound($contest,'first');
            $this->bounds[]=$this->select_bound($contest,'last');
        }

        #Random ID
        do {
            $rand = mt_rand($this->bounds[0], $this->bounds[1]);
        }while(in_array($rand,$this->rands) || $rand > $this->bounds[1]);

        #NOT Select Repetitive
        if(count($this->rands)>0){
            $this->db->where('id', array('NOT IN' => $this->rands));
        }
        #Query
        $this->db->where ("id", $rand);
        $user = $this->db->getOne('participants',array('id','name','email','mobile'));
        if ($this->db->count == 1){
            $this->rands[]=$rand;
            return $user;
        }else{
            return false;
        }
    }

    function available_prize($contest){
        $this->db->where ("status", 0);
        $this->db->where ("contest", $contest);
        $prize = $this->db->getOne('winners',array('id','name'));
        if ($this->db->count==1){
            return $prize;
        }else{
            return false;
        }
    }

    function available_prizes($contest){
        $this->db->orderBy("id",'asc');
        $this->db->where ("status", 0);
        $this->db->where ("contest", $contest);
        $prizes = $this->db->get('winners',null,array('id','name'));
        if ($this->db->count==0){
            return false;
        }else{
            return $prizes;
        }
    }

    function update_prize($prize_id,$participant_id){
        $this->db->where('id',$prize_id);
        if($this->db->update('winners',array('winner'=>$participant_id,'status'=>1))){
            if($this->db->count==1){return true;}
        }
        return false;
    }

    function count_available_prizes($contest){
        $this->db->where ("status", 0);
        $this->db->where ("contest", $contest);
        $stats = $this->db->getOne ("winners", "count(*) as cnt");
        return $stats['cnt'];
    }

    function draw($contest=null){
        if($contest==''){$contest=$this->current_contest;}
        $prizes=$this->available_prizes($contest);
        if($prizes==false){return false;}
        $out=array();
        foreach($prizes as $prize){
            #User
            $user=$this->select_random($contest);
            $this->update_prize($prize['id'],$user['id']);
            #Out
            $out[]=array(
                'user'=>array(
                    'id'=>$user['id'],
                    'name'=>$user['name'],
                    'mobile'=>$user['mobile'],
                    'email'=>$user['email']
                ),
                'prize'=>$prize['name'],
                'id'=>$this->generate_number($user['id'])
            );
        }
        #Save Text
        $this->save_text($out);
        #Masking Number
        $out=$this->masking_number($out);
        return $out;
    }

    function masking_number($array){
        for($i=0;$i<count($array);++$i){
            $array[$i]['user']['mobile']=substr($array[$i]['user']['mobile'],0,3).'***'.substr($array[$i]['user']['mobile'],-4,4);
        }
        return $array;
    }

    function generate_number($id){
        if($this->bounds[0]!=1){
            $id=$id-$this->bounds[0]+1001;
        }else{
            $id+=1000;
        }
        return $id;
    }

    function save_text($out){
        $text="\r\n";
        foreach($out as $o){
            $text.=$o['user']['mobile'].' : '.$o['user']['name'].' : '.$o['prize']."\r\n";
        }
        $fp = fopen('winners.txt', 'a');
        fwrite($fp, $text);
        fclose($fp);
    }
}