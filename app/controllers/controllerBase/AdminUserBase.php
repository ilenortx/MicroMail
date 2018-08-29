<?php

/**
 * 用户基类
 * @author xiao
 *
 */
class AdminUserBase extends ControllerBase{

    public function indexAction(){

    }
    
    
    /**
     * 用户列表
     * @param string $type au管理员 u用户
     */
    public function usersListAction($type="au"){
    	$usersList = array();
    	
    	if ($type == "au"){//获取管理员列表
    		$users = Adminuser::find(array(
    				'conditions'=>	"sid = ?1 and status != ?2",
    				'bind'		=>	array(1=>$this->session->get('sid'), 2=>'S2')
    		));
    		
    		if ($users) $usersList = $users->toArray();
    	}
    	
    	return $usersList;
    }
    
    /**
     * 操作用户状态
     * @param string $type au管理员 u用户
     * @param string $status S0 S1 S2
     */
    public function doUserStatusAction($type="au", $uid, $status="S0"){
    	$result = array();
    	
    	if ($type == "au"){
    		if ($uid == $this->session->get('uid')){//取消自己修改自己
    			
    		}else {
    			$result['status'] = 0;
    			$result['msg'] = "不能操作自己！";
    		}
    		
    		$user = Adminuser::findFirstById($uid);
    		if ($user){
    			$dor = false;
    			if ($status == "S2") {
    				$dor = $user->delete();
    			}else {
    				$user->status = $status;
    				$dor = $user->save();
    			}
    			
    			if ($dor) {
    				$result['status'] = 1;
    				$result['msg'] = "操作成功！";
    			}else {
    				$result['status'] = 0;
    				$result['msg'] = "操作失败！";
    			}
    		}else {
    			$result['status'] = 0;
    			$result['msg'] = "找不到用户！";
    		}
    		
    	}
    	
    	return $result;
    }
    
    
}

