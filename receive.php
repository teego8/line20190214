<?php
  	$json_str = file_get_contents('php://input'); //接收request的body
  	$json_obj = json_decode($json_str); //轉成json格式
  
  	$myfile = fopen("log.txt", "w+") or die("Unable to open file!"); //設定一個log.txt來印訊息
  	//fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  
  	$sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
  	$sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
  	$sender_replyToken = $json_obj->events[0]->replyToken; //取得訊息的replyToken
  	$msg_json = '{
  "type": "flex",
  "altText": "Flex Message",
  "contents": {
    "type": "bubble",
    "hero": {
      "type": "image",
      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_2_restaurant.png",
      "size": "full",
      "aspectRatio": "20:13",
      "aspectMode": "cover",
      "action": {
        "type": "uri",
        "label": "Action",
        "uri": "https://linecorp.com"
      }
    },
    "body": {
      "type": "box",
      "layout": "vertical",
      "spacing": "md",
      "action": {
        "type": "uri",
        "label": "Action",
        "uri": "https://linecorp.com"
      },
      "contents": [
        {
          "type": "text",
          "text": "Brown's Burger",
          "size": "xl",
          "weight": "bold"
        },
        {
          "type": "box",
          "layout": "vertical",
          "spacing": "sm",
          "contents": [
            {
              "type": "box",
              "layout": "baseline",
              "contents": [
                {
                  "type": "icon",
                  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/restaurant_regular_32.png"
                },
                {
                  "type": "text",
                  "text": "$10.5",
                  "flex": 0,
                  "margin": "sm",
                  "weight": "bold"
                },
                {
                  "type": "text",
                  "text": "400kcl",
                  "size": "sm",
                  "align": "end",
                  "color": "#AAAAAA"
                }
              ]
            },
            {
              "type": "box",
              "layout": "baseline",
              "contents": [
                {
                  "type": "icon",
                  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/restaurant_large_32.png"
                },
                {
                  "type": "text",
                  "text": "$15.5",
                  "flex": 0,
                  "margin": "sm",
                  "weight": "bold"
                },
                {
                  "type": "text",
                  "text": "550kcl",
                  "size": "sm",
                  "align": "end",
                  "color": "#AAAAAA"
                }
              ]
            }
          ]
        },
        {
          "type": "text",
          "text": "Sauce, Onions, Pickles, Lettuce & Cheese",
          "size": "xxs",
          "color": "#AAAAAA",
          "wrap": true
        }
      ]
    },
    "footer": {
      "type": "box",
      "layout": "vertical",
      "contents": [
        {
          "type": "spacer",
          "size": "xxl"
        },
        {
          "type": "button",
          "action": {
            "type": "uri",
            "label": "Add to Cart",
            "uri": "https://linecorp.com"
          },
          "color": "#905C44",
          "style": "primary"
        }
      ]
    }
  }
}';
  	$response = array (
		"replyToken" => $sender_replyToken,
		"messages" => array (
			array (
				"type" => "flex",
				"altText" => "This is a Flex Message",
				"contents" => json_decode($msg_json)
			)
		)
  	);
			
  	fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  	$header[] = "Content-Type: application/json";
  	$header[] = "Authorization: Bearer 6qhDIhQ++5j1febihav54eoLSlhGIbDJyE+yy95rx0tWd4X7pLUwfOsTlavVXXFPBzBMYZyuI21X9wLrsu+aAqM+iB1UE+UaTyKItGWzqouOAaEfwuSnRwDxeVx+Iz4fpwcNzdzAZ2iU/mBreIEk0gdB04t89/1O/w1cDnyilFU=";
  	$ch = curl_init("https://api.line.me/v2/bot/message/reply");
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
  	$result = curl_exec($ch);
  	curl_close($ch);
?>
