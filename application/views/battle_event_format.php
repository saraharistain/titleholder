[
    {
        "x": <?php echo $x_pos ? $x_pos:0; ?>,
        "y": <?php echo $y_pos ? $y_pos:0; ?>,
        "id": "<?php echo $m_id ? $m_id:0; ?>",
        "name": "<?php echo $name ? $name:'null'; ?>"
    },
    [
        {
            "character_hue": "<?php echo $avatar ? $avatar:null; ?>",
            "pattern": 2,
            "trigger": "action_button",
            "direction": "<?php echo $direction ? $direction:'bottom'; ?>",
            "frequence": 4,
            "type": "fixed",
            "through": false,
            "stop_animation": false,
            "no_animation": false,
            "direction_fix": false,
            "alwaysOnTop": false,
            "speed": 4,
            "commands":
            [
                "SHOW_TEXT: {'text': '<?php echo $msg ? $msg:null; ?>'}",
                "CALL: 'battle'"
            ]
        }
    ]
]