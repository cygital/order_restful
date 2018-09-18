#!/bin/bash
mysql -u root -psecret <<'EOF'
USE changedatabsename;
CREATE TABLE IF NOT EXISTS `orders` ( `id` int(11) NOT NULL AUTO_INCREMENT, `start_latitude` float NOT NULL, `start_longitude` float NOT NULL, `end_latitude` float NOT NULL, `end_longitude` float NOT NULL, `distance` float NOT NULL, `status` varchar(20) DEFAULT 'UNASSIGN', `created` datetime NOT NULL, `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`) );
EOF