

CREATE TABLE `users` (
  `id` int NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `permission` varchar(255) NOT NULL,
  `usr` varchar(255) NOT NULL,
  `uemail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `upwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uproject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `udomain` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `uuid`, `permission`, `usr`, `uemail`, `upwd`, `uproject`, `udomain`) VALUES
(22, '4c0b7be94eab7243cd2ccb1c7e43e6d8', '1', 'admin', 'admin@mail.ru', '827ccb0eea8a706c4c34a16891f84e7b', 'project', 'admin.ru');

CREATE TABLE `servers` (
  `id` int NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `sname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `slabel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `svendor` varchar(255) NOT NULL,
  `sactive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sstat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sversion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sup` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `licenses` (
  `id` int NOT NULL,
  `lname` varchar(255) NOT NULL,
  `luid` varchar(255) NOT NULL,
  `lserver` varchar(255) NOT NULL,
  `lvendor` varchar(255) NOT NULL,
  `ltotal` varchar(255) NOT NULL,
  `linuse` varchar(255) NOT NULL,
  `lusers` json NOT NULL,
  `lreservations` json NOT NULL,
  `lsum` varchar(255) NOT NULL,
  `lstatistics` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;