-- ============================================================
-- AptCode Database Schema
-- Import this in phpMyAdmin to set up the database
-- ============================================================

CREATE DATABASE IF NOT EXISTS aptcode CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE aptcode;

-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    total_score INT DEFAULT 0,
    streak INT DEFAULT 0,
    last_active DATE DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    avatar_initial VARCHAR(2) DEFAULT '',
    aptitude_solved INT DEFAULT 0,
    coding_solved INT DEFAULT 0,
    games_played INT DEFAULT 0,
    level INT DEFAULT 1,
    xp INT DEFAULT 0
);

-- APTITUDE QUESTIONS TABLE
CREATE TABLE IF NOT EXISTS aptitude_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic ENUM('quantitative','logical','verbal','puzzles','data','speed') NOT NULL,
    difficulty ENUM('easy','medium','hard') NOT NULL,
    question_text TEXT NOT NULL,
    option_a VARCHAR(300) NOT NULL,
    option_b VARCHAR(300) NOT NULL,
    option_c VARCHAR(300) NOT NULL,
    option_d VARCHAR(300) NOT NULL,
    correct_answer CHAR(1) NOT NULL,
    explanation TEXT,
    points INT DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CODING PROBLEMS TABLE
CREATE TABLE IF NOT EXISTS coding_problems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    difficulty ENUM('easy','medium','hard') NOT NULL,
    topic VARCHAR(100),
    description TEXT NOT NULL,
    examples TEXT,
    constraints TEXT,
    hint TEXT,
    points INT DEFAULT 20,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- USER PROGRESS TABLE
CREATE TABLE IF NOT EXISTS user_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    question_id INT,
    problem_id INT,
    type ENUM('aptitude','coding','game','daily') NOT NULL,
    status ENUM('attempted','correct','wrong','solved') NOT NULL,
    score INT DEFAULT 0,
    time_taken INT DEFAULT 0,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- DAILY CHALLENGES TABLE
CREATE TABLE IF NOT EXISTS daily_challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    challenge_date DATE NOT NULL UNIQUE,
    aptitude_question_id INT,
    coding_problem_id INT,
    bonus_points INT DEFAULT 50,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- USER DAILY COMPLETIONS
CREATE TABLE IF NOT EXISTS daily_completions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    challenge_date DATE NOT NULL,
    aptitude_done TINYINT(1) DEFAULT 0,
    coding_done TINYINT(1) DEFAULT 0,
    bonus_earned TINYINT(1) DEFAULT 0,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_date (user_id, challenge_date),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- USER SESSIONS / ACTIVITY LOG
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(200) NOT NULL,
    icon VARCHAR(10) DEFAULT '✅',
    points_earned INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================================
-- SEED DATA — APTITUDE QUESTIONS
-- ============================================================
INSERT INTO aptitude_questions (topic, difficulty, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, points) VALUES
-- Quantitative Easy
('quantitative','easy','If 20% of a number is 80, what is 30% of that number?','100','120','140','160','B','20% = 80, so 100% = 400. 30% of 400 = 120.',10),
('quantitative','easy','A train travels 300 km in 5 hours. What is its average speed?','50 km/h','60 km/h','55 km/h','70 km/h','B','Speed = Distance/Time = 300/5 = 60 km/h.',10),
('quantitative','easy','The average of 5 numbers is 20. If one number is removed, the average becomes 18. What was the removed number?','28','26','24','30','A','Sum of 5 = 100. Sum of 4 = 72. Removed = 100-72 = 28.',10),
('quantitative','medium','Two pipes A and B can fill a tank in 12 and 15 hours respectively. How long together?','6.5 hours','6 hours and 40 minutes','7 hours','5 hours 30 minutes','B','A+B per hour = 1/12+1/15 = 9/60 = 3/20. Time = 20/3 ≈ 6h 40min.',15),
('quantitative','medium','A shopkeeper buys goods at 20% discount on marked price and sells at 10% discount. Profit %?','12.5%','11.11%','15%','10%','A','Buy at 80, sell at 90. Profit = 10/80 = 12.5%.',15),
('quantitative','hard','The sum of three consecutive even numbers is 78. What is the largest number?','24','26','28','30','C','Let them be n-2, n, n+2. Sum=3n=78, n=26. Largest=28.',20),
-- Logical Easy
('logical','easy','Find the odd one out: 2, 3, 5, 7, 9, 11','9','7','11','3','A','All others are prime. 9 = 3×3 is not prime.',10),
('logical','easy','Complete the series: 2, 6, 12, 20, 30, ?','42','40','44','38','A','Differences: 4,6,8,10,12. Next = 30+12 = 42.',10),
('logical','medium','If A=1, B=2... Z=26, what is MATH?','42','44','43','41','B','M=13, A=1, T=20, H=8. Sum=42. Wait: 13+1+20+8=42. Answer A.',10),
('logical','medium','In a class of 40, 25 play cricket, 15 play football, 5 play both. How many play neither?','5','10','8','6','A','n(C∪F) = 25+15-5 = 35. Neither = 40-35 = 5.',15),
-- Verbal
('verbal','easy','Choose the synonym of BENEVOLENT','Kind','Cruel','Selfish','Angry','A','Benevolent means well-meaning and kindly.',10),
('verbal','easy','Identify the antonym of VERBOSE','Concise','Wordy','Lengthy','Detailed','A','Verbose means using more words than needed; antonym is concise.',10),
('verbal','medium','Choose the word that best fills the blank: The scientist''s theory was _____, supported by decades of research.','Dubious','Tenuous','Robust','Fragile','C','Robust means strong and sturdy, fitting the context of well-supported research.',15),
-- Puzzles
('puzzles','easy','I have cities but no houses. I have mountains but no trees. I have water but no fish. What am I?','A painting','A map','A globe','A book','B','A map has representations of cities, mountains, and water but none of the actual things.',10),
('puzzles','medium','A rooster lays an egg on the peak of a roof. Which way does it roll?','Left','Right','Roosters don''t lay eggs','Down the slope','C','Roosters are male birds and do not lay eggs!',15),
('puzzles','hard','You have a 3-gallon and 5-gallon jug. How do you measure exactly 4 gallons?','Fill 5, pour into 3, empty 3, pour remaining into 3, fill 5, top up 3','Fill 3, pour into 5, fill 3 again, pour into 5 until full, 1 remains in 3, empty 5, pour 1 in, fill 3, pour into 5','Impossible','Fill 5, pour 2 into 3','B','Fill 3→5 (5 has 3). Fill 3 again→5 (5 full, 1 in 3). Empty 5, pour 1 in. Fill 3, pour into 5 = 4.',20),
-- Data
('data','easy','In a bar chart, if January=50, February=80, March=60, what is the average?','63.3','60','65','70','A','(50+80+60)/3 = 190/3 ≈ 63.3.',10),
-- Speed
('speed','easy','A car goes from A to B at 60 km/h and returns at 40 km/h. Average speed?','50 km/h','48 km/h','52 km/h','45 km/h','B','Harmonic mean: 2×60×40/(60+40) = 4800/100 = 48 km/h.',10),
('speed','medium','Two trains 150m and 100m long travel at 60 km/h and 40 km/h towards each other. Time to cross?','9 seconds','10 seconds','11 seconds','12 seconds','A','Relative speed = 100 km/h = 250/9 m/s. Distance = 250m. Time = 250/(250/9) = 9s.',15);

-- ============================================================
-- SEED DATA — CODING PROBLEMS
-- ============================================================
INSERT INTO coding_problems (title, difficulty, topic, description, examples, constraints, hint, points) VALUES
('Two Sum','easy','Arrays','Given an array of integers nums and an integer target, return indices of the two numbers such that they add up to target.\n\nYou may assume that each input would have exactly one solution, and you may not use the same element twice.','Input: nums = [2,7,11,15], target = 9\nOutput: [0,1]\nExplanation: nums[0] + nums[1] = 2 + 7 = 9\n\nInput: nums = [3,2,4], target = 6\nOutput: [1,2]','2 <= nums.length <= 10^4\n-10^9 <= nums[i] <= 10^9\nOnly one valid answer exists.','Use a hash map to store the complement of each number.',20),
('Reverse String','easy','Strings','Write a function that reverses a string. The input string is given as an array of characters s. You must do this by modifying the input array in-place with O(1) extra memory.','Input: s = ["h","e","l","l","o"]\nOutput: ["o","l","l","e","h"]\n\nInput: s = ["H","a","n","n","a","h"]\nOutput: ["h","a","n","n","a","H"]','1 <= s.length <= 10^5\ns[i] is a printable ASCII character.','Use two pointers from both ends and swap.',10),
('Valid Parentheses','easy','Stack','Given a string s containing just the characters (, ), {, }, [ and ], determine if the input string is valid.','Input: s = "()"\nOutput: true\n\nInput: s = "()[]{}" \nOutput: true\n\nInput: s = "(]"\nOutput: false','1 <= s.length <= 10^4\ns consists of parentheses only ()[]{}','Use a stack. Push opening brackets, pop and match on closing.',20),
('Maximum Subarray','medium','Dynamic Programming','Given an integer array nums, find the subarray with the largest sum, and return its sum.','Input: nums = [-2,1,-3,4,-1,2,1,-5,4]\nOutput: 6\nExplanation: [4,-1,2,1] has the largest sum = 6.','1 <= nums.length <= 10^5\n-10^4 <= nums[i] <= 10^4','Kadane''s Algorithm: track current sum and max sum.',30),
('Merge Two Sorted Lists','medium','Linked Lists','You are given the heads of two sorted linked lists list1 and list2. Merge the two lists into one sorted list. Return the head of the merged linked list.','Input: list1 = [1,2,4], list2 = [1,3,4]\nOutput: [1,1,2,3,4,4]\n\nInput: list1 = [], list2 = [0]\nOutput: [0]','The number of nodes in both lists is in [0, 50].\n-100 <= Node.val <= 100\nBoth list1 and list2 are sorted in non-decreasing order.','Use a dummy head node and compare nodes iteratively.',30),
('Binary Search','easy','Searching','Given an array of integers nums sorted in ascending order, and an integer target, write a function to search target. Return the index if found, else -1.','Input: nums = [-1,0,3,5,9,12], target = 9\nOutput: 4\n\nInput: nums = [-1,0,3,5,9,12], target = 2\nOutput: -1','1 <= nums.length <= 10^4\nnums has unique values sorted in ascending order.','Maintain lo and hi pointers, check the mid element.',20),
('Climbing Stairs','easy','Dynamic Programming','You are climbing a staircase. It takes n steps to reach the top. Each time you can climb 1 or 2 steps. How many distinct ways can you climb to the top?','Input: n = 2\nOutput: 2\nExplanation: 1+1, or 2\n\nInput: n = 3\nOutput: 3\nExplanation: 1+1+1, 1+2, 2+1','1 <= n <= 45','Think of it like Fibonacci numbers. dp[i] = dp[i-1] + dp[i-2].',20),
('Longest Palindromic Substring','medium','Strings','Given a string s, return the longest palindromic substring in s.','Input: s = "babad"\nOutput: "bab" or "aba"\n\nInput: s = "cbbd"\nOutput: "bb"','1 <= s.length <= 1000\ns consists of only digits and English letters.','Expand around center for each character (and pair).',35),
('Number of Islands','medium','Graph/BFS/DFS','Given an m x n 2D binary grid representing a map of 1s (land) and 0s (water), return the number of islands.','Input: grid = [["1","1","1","1","0"],["1","1","0","1","0"],["1","1","0","0","0"],["0","0","0","0","0"]]\nOutput: 1','m, n >= 1\ngrid[i][j] is 0 or 1','Use DFS/BFS to mark connected land cells as visited.',35),
('LRU Cache','hard','Design','Design a data structure that follows the Least Recently Used (LRU) cache constraints. Implement LRUCache class with get and put methods in O(1) time.','LRUCache lRUCache = new LRUCache(2);\nlRUCache.put(1, 1); // cache is {1=1}\nlRUCache.put(2, 2); // cache is {1=1, 2=2}\nlRUCache.get(1);    // return 1\nlRUCache.put(3, 3); // evicts key 2','1 <= capacity <= 3000\n0 <= key <= 10^4\n0 <= value <= 10^5','Use a doubly linked list + hashmap combination.',50),
('Word Break','hard','DP/Backtracking','Given a string s and a dictionary of strings wordDict, return true if s can be segmented into a space-separated sequence of dictionary words.','Input: s = "leetcode", wordDict = ["leet","code"]\nOutput: true\n\nInput: s = "applepenapple", wordDict = ["apple","pen"]\nOutput: true','1 <= s.length <= 300\nwordDict contains no duplicate words.','Use DP. dp[i] = true if s[0..i] can be broken into dict words.',50);

-- ============================================================
-- Set up default daily challenge for today
-- ============================================================
INSERT IGNORE INTO daily_challenges (challenge_date, aptitude_question_id, coding_problem_id, bonus_points)
VALUES (CURDATE(), 1, 4, 50);
