INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('First Post', 'oizdar', 0, '2017-05-17 15:12:17');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('You tube post:
https://www.youtube.com/watch?v=pPkf7hylUuA', 'oizdar', 0, '2017-05-17 15:20:35');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('Longer text with some wraps.
First line.
The second.


Some Space.
Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text.

Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. ', 'oizdar', 0, '2017-05-17 15:26:54');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('Example message by example user. with example link: http://www.example.com', 'example', 0, '2017-05-17 16:21:35');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('next one', 'oizdar', 0, '2017-05-17 16:25:11');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('next one', 'example', 0, '2017-05-17 16:25:17');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('next onenext one', 'example', 0, '2017-05-17 16:25:25');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('next onenext onenext onenext onenext onenext one', 'example', 0, '2017-05-17 16:25:33');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('link without http example: www.example.com', 'oizdar', 0, '2017-05-17 16:56:47');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('another youtube link:

 https://youtu.be/pPkf7hylUuA', 'example', 0, '2017-05-17 17:19:47');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('More post to activate show older button', 'oizdar', 0, '2017-05-17 17:23:07');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('More post to activate show more button', 'oizdar', 0, '2017-05-17 17:23:13');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('More post to activate show more button', 'oizdar', 0, '2017-05-17 17:23:26');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('More post to activate show more button', 'oizdar', 0, '2017-05-17 17:23:34');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('example image

http://sergioandbanks.com/wp-content/uploads/2014/10/family-fun-day-1024x530.jpg', 'oizdar', 0, '2017-05-17 17:54:20');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('page 3 is needed', 'example', 0, '2017-05-17 18:23:59');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('page 3 is needed
page 3 is needed
page 3 is needed
page 3 is needed
', 'example', 0, '2017-05-17 18:24:17');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('page 3 is needed
page 3 is needed
', 'oizdar', 0, '2017-05-17 18:24:23');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('page 3 is needed
', 'oizdar', 0, '2017-05-17 18:24:27');
INSERT INTO `database`.posts (content, user, likes, create_date) VALUES ('20th post', 'oizdar', 0, '2017-05-17 18:25:17');


INSERT INTO `database`.comments (post_id, content, user, likes, create_date) VALUES (1, 'Example content.', 'oizdar', 0, '2017-05-17 15:51:18');
INSERT INTO `database`.comments (post_id, content, user, likes, create_date) VALUES (1, 'Second comment', 'oizdar', 0, '2017-05-17 15:51:50');
INSERT INTO `database`.comments (post_id, content, user, likes, create_date) VALUES (1, 'Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text. Long text.', 'oizdar', 0, '2017-05-17 15:53:14');
INSERT INTO `database`.comments (post_id, content, user, likes, create_date) VALUES (19, 'Example comment. Example.com', 'oizdar', 0, '2017-05-17 15:51:50');
INSERT INTO `database`.comments (post_id, content, user, likes, create_date) VALUES (17, 'comment', 'oizdar', 0, '2017-05-17 15:51:50');
INSERT INTO `database`.comments (post_id, content, user, likes, create_date) VALUES (17, 'Example comment with image: https://media.giphy.com/media/9fbYYzdf6BbQA/giphy.gif', 'oizdar', 0, '2017-05-17 15:51:50');


INSERT INTO `database`.users (email, username, password) VALUES ('examle@example.com', 'example', '$2y$10$ltGelrac2anKAKjg1BuQc.YFpDxQHHTuYhTv8SS8kllO6RJMfi0PG');
INSERT INTO `database`.users (email, username, password) VALUES ('xxx@xxx.pl', 'oizdar', '$2y$10$7VShXkipyyM9DbIj9nbj1ecYkm39j0sNc0FNlsQvHekM6OXyL28rG');
