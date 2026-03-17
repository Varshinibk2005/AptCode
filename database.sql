-- AptCode Database Setup
-- Run this in phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS aptcode_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE aptcode_db;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    avatar_color VARCHAR(7) DEFAULT '#6C63FF',
    total_score INT DEFAULT 0,
    aptitude_score INT DEFAULT 0,
    coding_score INT DEFAULT 0,
    streak INT DEFAULT 0,
    last_login DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Aptitude Questions Table
CREATE TABLE IF NOT EXISTS aptitude_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('logical','quantitative','verbal','puzzles') NOT NULL,
    difficulty ENUM('easy','medium','hard') NOT NULL,
    question TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL,
    explanation TEXT,
    points INT DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Coding Questions Table
CREATE TABLE IF NOT EXISTS coding_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    category VARCHAR(50),
    difficulty ENUM('easy','medium','hard') NOT NULL,
    description TEXT NOT NULL,
    example_input TEXT,
    example_output TEXT,
    hint TEXT,
    solution TEXT,
    points INT DEFAULT 20,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User Answers Table
CREATE TABLE IF NOT EXISTS user_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    question_id INT NOT NULL,
    question_type ENUM('aptitude','coding') NOT NULL,
    selected_option CHAR(1),
    is_correct BOOLEAN DEFAULT FALSE,
    points_earned INT DEFAULT 0,
    answered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Daily Challenges Table
CREATE TABLE IF NOT EXISTS daily_challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    challenge_date DATE UNIQUE NOT NULL,
    aptitude_question_id INT,
    coding_question_id INT,
    FOREIGN KEY (aptitude_question_id) REFERENCES aptitude_questions(id),
    FOREIGN KEY (coding_question_id) REFERENCES coding_questions(id)
);

-- Daily Challenge Completions
CREATE TABLE IF NOT EXISTS daily_completions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    challenge_date DATE NOT NULL,
    aptitude_completed BOOLEAN DEFAULT FALSE,
    coding_completed BOOLEAN DEFAULT FALSE,
    bonus_points INT DEFAULT 0,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_date (user_id, challenge_date)
);

-- Game Scores Table
CREATE TABLE IF NOT EXISTS game_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game_type VARCHAR(50) NOT NULL,
    score INT NOT NULL,
    played_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =====================
-- SAMPLE DATA
-- =====================

-- Aptitude Questions - Logical
INSERT INTO aptitude_questions (category, difficulty, question, option_a, option_b, option_c, option_d, correct_option, explanation, points) VALUES
('logical', 'easy', 'If all roses are flowers and some flowers fade quickly, which conclusion is valid?', 'All roses fade quickly', 'Some roses may fade quickly', 'No roses fade quickly', 'All flowers are roses', 'B', 'Since only some flowers fade quickly, and roses are flowers, it is possible (but not certain) that some roses fade quickly.', 10),
('logical', 'easy', 'Find the next number in the series: 2, 6, 12, 20, 30, ?', '40', '42', '44', '46', '42', 'Pattern: n*(n+1). So 1*2=2, 2*3=6, 3*4=12, 4*5=20, 5*6=30, 6*7=42.', 10),
('logical', 'medium', 'In a row, A is 7th from left and B is 9th from right. If they interchange, A becomes 11th from left. How many students are in the row?', '18', '19', '20', '21', 'B', 'After interchange, A is 11th from left. Originally B was 9th from right. Total = 11 + 9 - 1 = 19.', 15),
('logical', 'medium', 'A clock shows 3:15. What is the angle between the hour and minute hands?', '0°', '7.5°', '15°', '22.5°', 'B', 'At 3:15, minute hand is at 90°. Hour hand is at 90° + (15/60)*30° = 90° + 7.5° = 97.5°. Angle = 97.5 - 90 = 7.5°.', 15),
('logical', 'hard', 'Five friends A, B, C, D, E sit in a row. A is not adjacent to B or C. D is not adjacent to C. A is to the right of D. Which arrangement is possible?', 'DACBE', 'DEBCA', 'BAECD', 'CDABE', 'B', 'DEBCA: D...A✓(right), A not adj B✓, A not adj C✓, D not adj C✓. Valid!', 20),

-- Aptitude Questions - Quantitative
('quantitative', 'easy', 'If 20% of a number is 40, what is the number?', '160', '180', '200', '220', 'C', '20% of x = 40 → x = 40 × 100/20 = 200.', 10),
('quantitative', 'easy', 'A train 150m long passes a pole in 15 seconds. What is the speed of the train?', '8 m/s', '9 m/s', '10 m/s', '12 m/s', 'C', 'Speed = Distance/Time = 150/15 = 10 m/s.', 10),
('quantitative', 'medium', 'Two pipes A and B can fill a tank in 10 and 15 hours respectively. If both are opened together, how long to fill?', '5 hours', '6 hours', '7 hours', '8 hours', 'B', 'Combined rate = 1/10 + 1/15 = 3/30 + 2/30 = 5/30 = 1/6. Time = 6 hours.', 15),
('quantitative', 'medium', 'A shopkeeper marks price 25% above cost. He gives 10% discount. Profit %?', '10.5%', '12.5%', '15%', '17.5%', 'B', 'Let CP=100, MP=125, SP=125×0.9=112.5. Profit = 12.5%.', 15),
('quantitative', 'hard', 'A sum triples in 5 years at SI. In how many years will it become 9 times at the same rate?', '15 years', '20 years', '25 years', '30 years', 'B', 'Triples means SI = 2P in 5 years. Rate = 40% p.a. For 9 times: SI = 8P. 8P = P×40%×T → T = 20 years.', 20),

-- Aptitude Questions - Verbal
('verbal', 'easy', 'Choose the word most similar in meaning to BENEVOLENT:', 'Cruel', 'Kind', 'Selfish', 'Greedy', 'B', 'BENEVOLENT means well-meaning and kindly. Synonym: Kind.', 10),
('verbal', 'easy', 'Choose the correctly spelled word:', 'Accomodation', 'Accommodation', 'Accomadation', 'Acomodation', 'B', 'The correct spelling is ACCOMMODATION with double c and double m.', 10),
('verbal', 'medium', 'Select the best word to fill: "The scientist made a _____ discovery that changed medicine forever."', 'trivial', 'minor', 'landmark', 'ordinary', 'C', 'LANDMARK means a significant event or achievement. It fits the context of a major discovery.', 15),
('verbal', 'hard', 'Identify the grammatically correct sentence:', 'Neither of the boys have done their homework.', 'Neither of the boys has done his homework.', 'Neither of the boys have done his homework.', 'Neither boys have done their homework.', 'B', '"Neither" takes a singular verb. Correct: "Neither of the boys has done his homework."', 20),

-- Aptitude Questions - Puzzles
('puzzles', 'easy', 'I have cities, but no houses live there. I have mountains, but no trees grow. I have water, but no fish swim. I have roads, but no cars drive. What am I?', 'A dream', 'A painting', 'A map', 'A photograph', 'C', 'A MAP has representations of cities, mountains, water bodies, and roads but none of the actual physical things.', 10),
('puzzles', 'medium', 'You have two jugs: one holds 3 liters, one holds 5 liters. How do you measure exactly 4 liters?', 'Fill the 3L jug', 'Fill 5L, pour into 3L, empty 3L, pour rest into 3L, fill 5L again, fill up 3L', 'Fill the 5L jug twice', 'It is impossible', 'B', 'Fill 5L → pour into 3L (3L full, 2L in 5L jug) → empty 3L → pour 2L into 3L → fill 5L → pour into 3L (needs 1L) → 4L remains in 5L!', 15),
('puzzles', 'hard', 'Three boxes: one has apples, one has oranges, one has both. All labels are WRONG. You can pick one fruit from one box. Which box do you pick from to identify all?', 'Box labeled Apples', 'Box labeled Oranges', 'Box labeled Both', 'Any box', 'C', 'Pick from "Both" box. Since all labels are wrong, it must have either only apples or only oranges. That tells you its true content, and since the other labels are also wrong, you can deduce the rest.', 20);

-- Coding Questions
INSERT INTO coding_questions (title, category, difficulty, description, example_input, example_output, hint, solution, points) VALUES
('Reverse a String', 'Strings', 'easy', 'Write a function to reverse a given string without using built-in reverse functions.\n\nConstraints:\n- Input string length: 1 to 1000\n- String contains only ASCII characters', '"hello"', '"olleh"', 'Use two pointers: one at start, one at end, swap and move towards center.', 'function reverseString(s) {\n  let arr = s.split("");\n  let left = 0, right = arr.length - 1;\n  while (left < right) {\n    [arr[left], arr[right]] = [arr[right], arr[left]];\n    left++; right--;\n  }\n  return arr.join("");\n}', 20),

('FizzBuzz', 'Basics', 'easy', 'Print numbers from 1 to N. But for multiples of 3 print "Fizz", for multiples of 5 print "Buzz", and for multiples of both 3 and 5 print "FizzBuzz".', 'N = 15', '1 2 Fizz 4 Buzz Fizz 7 8 Fizz Buzz 11 Fizz 13 14 FizzBuzz', 'Use the modulo (%) operator. Check for 15 first, then 3, then 5.', 'for (let i = 1; i <= n; i++) {\n  if (i % 15 === 0) console.log("FizzBuzz");\n  else if (i % 3 === 0) console.log("Fizz");\n  else if (i % 5 === 0) console.log("Buzz");\n  else console.log(i);\n}', 20),

('Two Sum', 'Arrays', 'easy', 'Given an array of integers and a target sum, return the indices of two numbers that add up to the target. Each input has exactly one solution.', '[2, 7, 11, 15], target = 9', '[0, 1]', 'Use a hash map to store each number and its index. For each number, check if (target - number) exists in the map.', 'function twoSum(nums, target) {\n  const map = new Map();\n  for (let i = 0; i < nums.length; i++) {\n    const complement = target - nums[i];\n    if (map.has(complement)) return [map.get(complement), i];\n    map.set(nums[i], i);\n  }\n}', 20),

('Valid Parentheses', 'Stacks', 'medium', 'Given a string containing only (, ), {, }, [, ], determine if the input string is valid. An input string is valid if: open brackets are closed by the same type, open brackets are closed in correct order.', '"()[]{}"', 'true', 'Use a stack. Push opening brackets, pop and check matching when you see a closing bracket.', 'function isValid(s) {\n  const stack = [];\n  const map = { ")": "(", "}": "{", "]": "[" };\n  for (let c of s) {\n    if ("({[".includes(c)) stack.push(c);\n    else if (stack.pop() !== map[c]) return false;\n  }\n  return stack.length === 0;\n}', 30),

('Fibonacci with Memoization', 'Dynamic Programming', 'medium', 'Compute the Nth Fibonacci number efficiently. Use memoization to avoid redundant calculations.\n\nF(0)=0, F(1)=1, F(n)=F(n-1)+F(n-2)', 'N = 10', '55', 'Store computed results in a cache (object/array) before recursing. Check cache before computing.', 'function fib(n, memo = {}) {\n  if (n in memo) return memo[n];\n  if (n <= 1) return n;\n  memo[n] = fib(n-1, memo) + fib(n-2, memo);\n  return memo[n];\n}', 30),

('Longest Common Subsequence', 'Dynamic Programming', 'hard', 'Given two strings, find the length of their longest common subsequence (LCS). A subsequence is a sequence that can be derived by deleting some characters without changing the order.', '"ABCBDAB", "BDCAB"', '4 (BCAB or BDAB)', 'Build a 2D DP table. dp[i][j] = LCS length of first i chars of s1 and first j chars of s2.', 'function lcs(s1, s2) {\n  const m = s1.length, n = s2.length;\n  const dp = Array(m+1).fill(null).map(() => Array(n+1).fill(0));\n  for (let i = 1; i <= m; i++)\n    for (let j = 1; j <= n; j++)\n      dp[i][j] = s1[i-1] === s2[j-1] ? dp[i-1][j-1] + 1 : Math.max(dp[i-1][j], dp[i][j-1]);\n  return dp[m][n];\n}', 40),

('Binary Search', 'Searching', 'easy', 'Implement binary search. Given a sorted array and a target value, return the index of the target. If not found, return -1.', '[1,3,5,7,9,11], target=7', '3', 'Maintain low and high pointers. Calculate mid. If arr[mid] equals target, return mid.', 'function binarySearch(arr, target) {\n  let low = 0, high = arr.length - 1;\n  while (low <= high) {\n    const mid = Math.floor((low + high) / 2);\n    if (arr[mid] === target) return mid;\n    else if (arr[mid] < target) low = mid + 1;\n    else high = mid - 1;\n  }\n  return -1;\n}', 20),

('Merge Sort', 'Sorting', 'medium', 'Implement the merge sort algorithm. Split the array in half recursively, sort each half, and merge them back together in sorted order.', '[38,27,43,3,9,82,10]', '[3,9,10,27,38,43,82]', 'Divide array into two halves. Recursively sort each half. Merge the sorted halves.', 'function mergeSort(arr) {\n  if (arr.length <= 1) return arr;\n  const mid = Math.floor(arr.length / 2);\n  const left = mergeSort(arr.slice(0, mid));\n  const right = mergeSort(arr.slice(mid));\n  return merge(left, right);\n}\nfunction merge(l, r) {\n  const res = [];\n  let i = 0, j = 0;\n  while (i < l.length && j < r.length)\n    res.push(l[i] <= r[j] ? l[i++] : r[j++]);\n  return res.concat(l.slice(i)).concat(r.slice(j));\n}', 30);

-- Daily Challenges (seed with today)
INSERT INTO daily_challenges (challenge_date, aptitude_question_id, coding_question_id)
VALUES (CURDATE(), 3, 3)
ON DUPLICATE KEY UPDATE aptitude_question_id=3, coding_question_id=3;

-- Create a demo user (password: demo123)
INSERT INTO users (username, email, password, full_name, total_score, aptitude_score, coding_score, streak)
VALUES ('demo_user', 'demo@aptcode.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Demo Student', 250, 120, 130, 5);

SELECT 'AptCode database setup complete!' AS Status;
