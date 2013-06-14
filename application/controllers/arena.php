<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Arena extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('auth') !== true) {
            redirect(site_url('login'));
        }

        $this->load->helper('file');
    }

	public function index()
	{
        $data = array();
        $monsters = null;
        $user = null;
        $events = array();
        $user_id = $this->session->userdata('userid');
        $user_data = $this->users->get_userdata($user_id);

        // get monsters / enemies
        if ($user_data) {
            $user = $user_data;

            $where = "monster_level BETWEEN {$user_data->level} AND {$user_data->level} + 5";

            $monsters = $this->monsters->getByLevel($where);

            if ($monsters && count($monsters) > 0) {
                $events = $this->generateEnemyEvents($monsters);
            } else {
                $events = $this->generateDefaultEvent();
            }

        }

        if (count($events) > 0) {
            $data['events'] = $events;
        } else {
            $data['events'] = array('null');
        }

        $data['user'] = $user;
        $data['header'] = $this->load->view('headers', null, true);
        $this->load->view('arena', $data);
	}

    private function generateEnemyEvents($monsters = array())
    {
        $events = array();
        $file_path =  getcwd() . '/assets/Data/Events/MAP001/'; //will be changed, used in prod
        $file_name = "EV00";
        $ctr = 4; // 4 start of the count for there are default 4 events.
        $dataOptions = array();
        $directions = array('top', 'bottom', 'left', 'right');

        $msg1 = array(
            'You dared to challenge me?',
            'Want my title huh?!?',
            'Let\'s get this over with',
            'Escape now while you have the time!'
        );

        $msg2 = array(
            'Do you think you can defeat me?',
            'Ha!! Prepare to die!',
            'You will never be the Title Holder!!',
            'Say hello to your ancestors!'
        );

        if (count($monsters) > 0) {
            // generating battle event for each monster
            foreach ($monsters as $m_info) {
                $ctr++;
                $f_name = $file_name.$ctr;

                $events[] = $f_name;

                $msg_key_1 = array_rand($msg1);
                $msg_key_2 = array_rand($msg2);

                $direction_key1 = array_rand($directions);
                $direction_key2 = array_rand($directions);

                $dataOptions['m_id'] = $m_info->monster_id;
                $dataOptions['name'] = $f_name;
                $dataOptions['avatar'] = $m_info->monster_avatar;
                $dataOptions['msg1'] = $msg1[$msg_key_1];
                $dataOptions['msg2'] = $msg2[$msg_key_2];
                $dataOptions['directions_1'] = $directions[$direction_key1];
                $dataOptions['directions_2'] = $directions[$direction_key2];
                $dataOptions['eventCall'] = ",\"CALL: 'battle'\"";

                // set the X and Y position of characters
                switch ($ctr) {
                    case 5:
                        $dataOptions['x_pos'] = 25;
                        $dataOptions['y_pos'] = 32;
                        break;
                    case 6:
                        $dataOptions['x_pos'] = 22;
                        $dataOptions['y_pos'] = 43;
                        break;
                    case 7:
                        $dataOptions['x_pos'] = 38;
                        $dataOptions['y_pos'] = 17;
                        break;
                }

                $event = $this->load->view('battle_event_format', $dataOptions, true);

                $fp = fopen($file_path . $f_name . '.json', 'w+');
                if (!fwrite($fp, $event)) {
                    echo "File not written \n";
                }
                fclose($fp);
            }
        }
        return $events;
    }

    private function generateDefaultEvent()
    {
        $events = array();
        $file_path =  getcwd() . '/assets/Data/Events/MAP001/'; //will be changed, used in prod
        $file_name = "EV00";
        $dataOptions = array();
        $directions = array('top', 'bottom', 'left', 'right');

        $msg1 = array(
            'Hello!?',
            '??',
            '!!!',
            ' '
        );

        $msg2 = array(
            'I\'m busy',
            'Are you the title holder?',
            'Red Moon Kingdom is in North of this town',
            'Get all the titles!'
        );

        for ($ctr = 5 ; $ctr < 8 ; $ctr++) {
            $f_name = $file_name.$ctr;
            $events[] = $f_name;

            $msg_key_1 = array_rand($msg1);
            $msg_key_2 = array_rand($msg2);

            $direction_key1 = array_rand($directions);
            $direction_key2 = array_rand($directions);

            $dataOptions['m_id'] = $ctr;
            $dataOptions['name'] = $f_name;
            $dataOptions['avatar'] = "s_0" . $ctr . ".png";
            $dataOptions['msg1'] = $msg1[$msg_key_1];
            $dataOptions['msg2'] = $msg2[$msg_key_2];
            $dataOptions['directions_1'] = $directions[$direction_key1];
            $dataOptions['directions_2'] = $directions[$direction_key2];
            $dataOptions['eventCall'] = null;

            // set the X and Y position of characters
            switch ($ctr) {
                case 5:
                    $dataOptions['x_pos'] = 25;
                    $dataOptions['y_pos'] = 32;
                    break;
                case 6:
                    $dataOptions['x_pos'] = 22;
                    $dataOptions['y_pos'] = 43;
                    break;
                case 7:
                    $dataOptions['x_pos'] = 38;
                    $dataOptions['y_pos'] = 17;
                    break;
            }

            $event = $this->load->view('battle_event_format', $dataOptions, true);

            $fp = fopen($file_path . $f_name . '.json', 'w+');
            if (!fwrite($fp, $event)) {
                echo "File not written \n";
            }
            fclose($fp);
        }
        return $events;
    }

    public function generateEventReplacement()
    {
        $user_id = $this->session->userdata('userid');
        $user_data = $this->users->get_userdata($user_id);

        // get monsters / enemies
        if ($user_data) {
            $user = $user_data;

            $where = "monster_level BETWEEN {$user_data->level} AND {$user_data->level} + 5";

            $monsters = $this->monsters->getByLevel($where);

            if ($monsters && count($monsters) > 0) {
                $events = $this->generateEnemyEvents($monsters);
            } else {
                $events = $this->generateDefaultEvent();
            }

        }
    }
}

/* End of file arena.php */
/* Location: ./application/controllers/arena.php */