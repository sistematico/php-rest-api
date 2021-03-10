CREATE TABLE IF NOT EXISTS 'sessions' (
  'id' INTEGER NOT NULL PRIMARY KEY,
  'userid' INTEGER NOT NULL,
  'accesstoken' TEXT NOT NULL UNIQUE,
  'accesstokenexpiry' datetime NOT NULL,
  'refreshtoken' TEXT NOT NULL UNIQUE,
  'refreshtokenexpiry' datetime NOT NULL,
  FOREIGN KEY(userid) REFERENCES tblusers(id)
);

CREATE TABLE IF NOT EXISTS 'users' (
  'id' INTEGER NOT NULL PRIMARY KEY,
  'fullname' TEXT NOT NULL ,
  'username' TEXT NOT NULL UNIQUE,
  'email' TEXT NOT NULL UNIQUE,
  'password' TEXT NOT NULL,
  'active' TEXT NOT NULL DEFAULT 'Y',
  'loginattempts' INTEGER NOT NULL DEFAULT '0'
);

-- CREATE TABLE IF NOT EXISTS 'tasks' (
--   'id' INTEGER NOT NULL PRIMARY KEY,
--   'userid' INTEGER NOT NULL,
--   'title' TEXT NOT NULL,
--   'description' TEXT,
--   'deadline' datetime DEFAULT NULL ,
--   'completed' TEXT NOT NULL DEFAULT 'N',
--   FOREIGN KEY(userid) REFERENCES users(id)
-- );

