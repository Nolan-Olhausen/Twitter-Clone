# Twitter-Clone

A full-featured Twitter clone built with **PHP**, **HTML**, **JavaScript**, and **CSS**, showcasing all core functionalities of a social media platform. This application uses **AWS S3** for storing images (e.g., posts and profile pictures) and **MySQL** for user, post, and interaction data.

---

## Table of Contents

1. [Features](#features)
2. [Tech Stack](#tech-stack)
3. [Database Schema](#database-schema)
4. [Screenshots](#screenshots)

---

## Features

This Twitter clone includes the following functionalities:

- **Post Content**: Share text and images.
- **Engage**: Like, retweet, and quote retweet posts.
- **Interact**: Comment on posts.
- **Follow System**: Follow/unfollow users.
- **Explore Page**: Discover posts from unfollowed users.
- **Search**: Find posts and users.
- **Messaging**: Send and receive direct messages.
- **AWS S3 Integration**: Store images efficiently.
- **Responsive Design**: Almost completely responsive across different devices. Mobile design was not in consideration originally, but a good majority of it has been adapted.

---

## Tech Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Storage**: AWS S3

---

## Database Schema

The Twitter clone uses a MySQL database to manage all user and application data. Below is an overview of the key tables, their purposes, and relationships:

#### Key Tables

1. **`users`**
   - Stores user data such as email, username, password, profile image, bio, and access level.
   - Each user has a unique ID.

2. **`posts`**
   - Contains posts created by users, including the `posted_time`.
   - Each post is linked to its author (`user_id`).

3. **`postContent`**
   - Stores the text and/or image associated with posts.
   - Linked to the `posts` table by `post_id`.

4. **`likes`**
   - Tracks user interactions (likes) on posts.
   - Links users (`user_id`) to liked posts (`post_id`).

5. **`comments`**
   - Stores comments made on posts, along with the comment text and timestamp.
   - Links each comment to a user (`user_id`) and a post (`post_id`).

6. **`replies`**
   - Tracks replies to comments.
   - Links replies to a specific comment (`comment_id`) and the replying user (`user_id`).

7. **`follow`**
   - Manages follow relationships between users.
   - Tracks the `sender` (follower) and `receiver` (followee) with timestamps.

8. **`messages`**
   - Stores direct messages exchanged between users, including the message content and timestamp.
   - Links messages to the sender (`messageFrom`) and receiver (`messageTo`).

9. **`notifications`**
   - Tracks events such as follows, likes, retweets, quotes, comments, replies, and mentions.
   - Includes details about the target user (`notify_for`), triggering user (`notify_from`), and the event type.

10. **`echoes`**
    - Manages retweets and quote retweets, linking them to the original post and additional message text, if any.
    - Allows recursive references for nested retweets using `echo_id`.

#### Relationships

- **`users`** is the central table, with foreign keys linking it to almost all other tables (`posts`, `likes`, `comments`, `follows`, etc.).
- Posts and their related content (likes, comments, retweets) cascade changes to maintain consistency when a post is deleted or updated.
- Notifications provide insights into interactions, while messages facilitate direct communication between users.

#### Database Schema File

For a detailed SQL implementation of the schema, refer to the [`nolhausen.sql`](https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/src/nolhausen.sql) file in the repository.

---

## Screenshots

Here are some screenshots showcasing the core features of the Twitter clone:

### 1. Home Feed
The main timeline displaying posts from followed users and yourself. 
Note: This screenshot also displays how "retweets" (echoes in my implementation) look in the feed, with the top post being a quote "retweet".

<img src="https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/twitterImages/homePage.png" alt="Home Feed">

### 2. Explore Feed
A discovery page highlighting posts from users not followed at random.

<img src="https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/twitterImages/explorePage.png" alt="Explore Feed">

### 3. Profile Page
A user’s profile page displaying their posts, followers, and following.

<img src="https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/twitterImages/profilePage.png" alt="Profile Page">

### 4. Status Page
A detailed view of a single post with comments, likes, and retweets.

<img src="https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/twitterImages/statusPage.png" alt="Status Page">

### 5. Search Results Page
Search functionality showcasing users and posts matching the query.

You can search by name/username and it will return matching users and posts
<img src="https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/twitterImages/userSearch.png" alt="Search Results">

You can also search by post text for matching posts
<img src="https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/twitterImages/postSearch.png" alt="Search Results 2">

### 6. Inbox Page
The inbox section where users can view their messages. It will display a preview of the most recent message of each chat

<img src="https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/twitterImages/inboxPage.png" alt="Inbox Page">

### 7. Message Chat Page
A real-time chat interface for direct messaging between users.

<img src="https://github.com/Nolan-Olhausen/Twitter-Clone/blob/main/twitterImages/messagePage.png" alt="Message Page">
