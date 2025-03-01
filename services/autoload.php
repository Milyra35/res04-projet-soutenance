<?php

// Require all the models
require 'models/Book.php';
require 'models/CommunityCenter.php';
require 'models/Item.php';
require 'models/Location.php';
require 'models/Museum.php';
require 'models/Picture.php';
require 'models/PlayerProgress.php';
require 'models/PlayerSkill.php';
require 'models/PossessedItem.php';
require 'models/Relationship.php';
require 'models/Role.php';
require 'models/SavedFile.php';
require 'models/Statistic.php';
require 'models/User.php';
require 'models/Villager.php';
require 'models/VillagerPlanning.php';

// Require all the managers
require 'managers/AbstractManager.php';
require 'managers/PictureManager.php';
require 'managers/UserManager.php';
require 'managers/FileManager.php';
require 'managers/VillagerManager.php';
require 'managers/ItemManager.php';
require 'managers/BookManager.php';
require 'managers/CommunityCenterManager.php';
require 'managers/LocationManager.php';
require 'managers/MuseumManager.php';
require 'managers/PlayerSkillManager.php';
require 'managers/PlayerProgressManager.php';
require 'managers/PossessedItemManager.php';
require 'managers/RelationshipManager.php';
require 'managers/StatisticManager.php';
require 'managers/VillagerPlanningManager.php';

// Require all the controllers
require 'controllers/AbstractController.php';
require 'controllers/UserController.php';
require 'controllers/FileController.php';
require 'controllers/AdminController.php';
require 'controllers/ItemController.php';
require 'controllers/MediaController.php';
require 'controllers/NPCController.php';
require 'controllers/ProgressBoardController.php';
require 'controllers/StaticPageController.php';

// Require the router
require 'services/Router.php';

?>