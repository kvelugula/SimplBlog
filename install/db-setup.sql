--
-- Table structure for table `tab_comments`
--

CREATE TABLE IF NOT EXISTS `tab_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postId` int(11) NOT NULL,
  `commentText` text NOT NULL,
  `authorName` varchar(255) NOT NULL,
  `authorEmail` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_comments`
--

INSERT IGNORE INTO `tab_comments` (`id`, `postId`, `commentText`, `authorName`, `authorEmail`, `ts`) VALUES(1, 1, 'Comment #1', 'Krishna V', 'user@google.com', '2014-04-05 11:24:46');
INSERT IGNORE INTO `tab_comments` (`id`, `postId`, `commentText`, `authorName`, `authorEmail`, `ts`) VALUES(2, 1, 'Comment #2', 'Krishna V', 'user@google.com', '2014-04-05 11:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `tab_posts`
--

CREATE TABLE IF NOT EXISTS `tab_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postTitle` varchar(255) NOT NULL,
  `postText` text NOT NULL,
  `authorName` varchar(255) NOT NULL,
  `authorEmail` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_posts`
--

INSERT IGNORE INTO `tab_posts` (`id`, `postTitle`, `postText`, `authorName`, `authorEmail`, `ts`) VALUES(1, 'Sample Blog Post #1', 'This is a Test Blog with a LINK&#13;&#10;&#13;&#10;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in sollicitudin nisi. Nullam vehicula metus dui, in aliquet enim ullamcorper consequat. Duis porttitor cursus nibh id consequat. In at luctus neque. Phasellus faucibus, felis ut pretium aliquet, turpis urna pellentesque libero, eu aliquet erat magna non sem. Suspendisse venenatis lacus quis auctor aliquet. Ut non sem ut purus consectetur sagittis vitae eget orci. Morbi volutpat tincidunt ante, non ultrices augue dignissim ut. Cras faucibus viverra tellus, vitae accumsan purus accumsan sed. Nam blandit enim vel purus pretium facilisis sagittis ac lorem. Sed ultricies ante sit amet sapien blandit facilisis.&#13;&#10;&#13;&#10;&#13;&#10;&#60;a href=&#34;http://www.w3schools.com&#34;&#62;&#13;&#10;This is a link&#60;/a&#62;&#13;&#10;', 'Krishna V', 'user@google.com', '2014-04-05 11:22:58');
INSERT IGNORE INTO `tab_posts` (`id`, `postTitle`, `postText`, `authorName`, `authorEmail`, `ts`) VALUES(2, 'Sample Blog Post #2', 'This is a  simple post', 'Krishna V', 'user@google.com', '2014-04-05 11:24:14');