diamondApp.controller('startCtrl', ['$scope', 'startSvc', '$location', '$timeout', '$anchorScroll', function($scope, startSvc, $location, $timeout, $anchorScroll) {

	//Scope variables
	$scope.allQuestionPosts = [];
	$scope.allTranslations = [];
	$scope.allCourses = [];
    $scope.allContacts = [];
    $scope.allPartners = [];
	$scope.postInFocus = null;
	$scope.hasViewedAboutDiamond = false;
	$scope.oneAtATime = true;
    $scope.currentLanguage = currentLanguage;
    $scope.languages = [
        {"name": "Svenska", "url": baseUrl.concat("/sv")},
        {"name": "English", "url": baseUrl.concat("/en")}
    ];
    $scope.isLoaded = {
        "translations": false,
        "questionPosts": false,
        "contacts": false,
        "partners": false,
        "all": false
    };
    
    $scope.$watch('isLoaded', function(){
        var allLoaded = true;
        angular.forEach($scope.isLoaded, function (value) {
            if(value === false){
                var allLoaded = false;
            }
        });
        if(allLoaded) {
            $scope.isLoaded.all = true;
        }
    }, true);

	// Sets custom strings from translation custom post type
	$scope.setCustomStrings = function(){
		$scope.leadershipOS = $scope.getTranslationByContent('leadershipOS');
		$scope.leadershipdiamond = $scope.getTranslationByContent('leadershipdiamond');
		$scope.nothingButApps = $scope.getTranslationByContent('nothingbutapps');
		$scope.readMore = "Läs mer";// $scope.getTranslationByContent('nothingbutapps');
		$scope.howToHandle = $scope.getTranslationByContent('howtohandle');
		$scope.close = $scope.getTranslationByContent('close');
		$scope.goToNextPost = $scope.getTranslationByContent('gotonextpost');
		$scope.aboutDiamond = $scope.getTranslationByContent('aboutdiamond');
        $scope.contact = $scope.getTranslationByContent('contact');
        $scope.leadershipPartners = $scope.getTranslationByContent('leadershippartners');
	};

	//On Document ready
	jQuery( document ).ready(function() {
		console.log( "ready!" );

	});

	//Scope functions on page load
	$scope.getTranslationByContent = function(content){
		var translation = $scope.allTranslations.filter(function(item) { return item.content === content; });
		return translation[0];
	};

	$scope.trimPostContent = function(content){
		return content.replace(/<\/?[^>]+(>|$)/g, "").replace(/(\r\n|\n|\r)/gm," ").trim();
	};

	$scope.defineQuestionPostObjects = function(){
		var count = 1;
		angular.forEach($scope.allQuestionPosts, function(post){
			post["showDescription"] = false;
			post["inFocus"] = false;
			post["index"] = parseInt(post['custom_fields']['wpcf-index'][0]);
			post["solution"] = (post['custom_fields']['wpcf-answer'][0]);
            post["isRead"] = false;
			post.content = $scope.trimPostContent(post.content);
			if (count === $scope.allQuestionPosts.length) {
				$scope.loading = false;
			};
			count++;
		});
	};

	$scope.getAllQuestionPosts = function(){
		startSvc.getAllQuestionPosts().then(function(response){
			$scope.allQuestionPosts = response.data.posts;
			console.log($scope.allQuestionPosts);
			$scope.defineQuestionPostObjects();
            $scope.isLoaded.questionPosts = true; 
		}).catch(function(){
            $scope.isLoaded.questionPosts = true; 
        });
	};

	$scope.prettyfyTranslations = function(translations){
		angular.forEach(translations, function(post){
			var transObject = {
				id: post.id,
				content: $scope.trimPostContent(post.content),
				title: post.title
			}
			if ('wpcf-extra-content' in post.custom_fields) {
				transObject["extraContent"] = post.custom_fields['wpcf-extra-content'][0];
			};
			$scope.allTranslations.push(transObject);
		});
		console.log("all translations");
		console.log($scope.allTranslations);
		//Set the custom strings
		$scope.setCustomStrings();
	};


	$scope.getAllTranslations = function(){
        var postType = 'translation';
		startSvc.getPostsByType(postType).then(function(response){
			$scope.prettyfyTranslations(response.data.posts);
            $scope.isLoaded.translations = true;
		}).catch(function(){
            console.log("Error in get all translations");
            $scope.isLoaded.translations = true;
        });
	};

	$scope.getAllCourses = function(){
        var postType = 'course';
		startSvc.getPostsByType(postType).then(function(response){
			$scope.allCourses = response.data.posts;
			angular.forEach($scope.allCourses, function(course){
				course.content = $scope.trimPostContent(course.content);
				if ('wpcf-course-index' in course.custom_fields) {
					course["courseIndex"] = course.custom_fields['wpcf-course-index'][0];
				};
				if ('wpcf-level' in course.custom_fields) {
					course["level"] = course.custom_fields['wpcf-level'][0];
				};
                course["isRead"] = false;
			});
			console.log("all courses");
			console.log($scope.allCourses);
            $scope.isLoaded.courses = true;
		}).catch(function(){
            console.log("Error in get all courses");
            $scope.isLoaded.courses = true;
        });
	};
    
    $scope.getFooterContent = function(){
        //Get contacts
        var postType = 'contact';
        startSvc.getPostsByType(postType).then(function(response){
            $scope.allContacts = response.data.posts;
            angular.forEach($scope.allContacts, function(contact){
                if ('wpcf-url' in contact.custom_fields) {
					contact["url"] = contact.custom_fields['wpcf-url'][0];
				};	
            });
            console.log($scope.allContacts);
            $scope.isLoaded.contacts = true;
            //Get leadership partners
            var postType = 'partner';
            startSvc.getPostsByType(postType).then(function(response){
                $scope.allPartners = response.data.posts;
                angular.forEach($scope.allPartners, function(partner){
                    if ('wpcf-url' in partner.custom_fields) {
                        partner["url"] = partner.custom_fields['wpcf-url'][0];
                    };		
                });
                console.log($scope.allPartners);
                $scope.isLoaded.partners = true;
            });

        }).catch(function(){
            console.log("Error in get all contacts");
            $scope.isLoaded.contacts = true;
            $scope.isLoaded.partners = true;
        });
        
    };
    
    $scope.registerQuestionClick = function(post){
        post.isRead = true;  
        $scope.gotoDivId("post-" + post.index);
    };
    
    $scope.moveToNextPost = function(currentPost){
        var nextPost = $scope.getQuestionPostByIndex(currentPost.index + 1);
        if(currentPost.index < $scope.allQuestionPosts.length){
            $timeout(function(){
                jQuery("#post-" + nextPost.index + " a").click();
            });
        };
	};
    
    $scope.gotoDivId = function(divId) {
      //var newHash = 'post-' + postId;
      if ($location.hash() !== divId) {
        // set the $location.hash to `newHash` and
        // $anchorScroll will automatically scroll to it
        $location.hash(divId);
      } else {
        // call $anchorScroll() explicitly,
        // since $location.hash hasn't changed
        $anchorScroll();
      }
    };
    
    $scope.getQuestionPostByIndex = function(postIndex){
        var returnPost = null;
        angular.forEach($scope.allQuestionPosts, function(post){
           if(post.index == postIndex){
               returnPost = post;
           } 
        });
      return returnPost;
    };

	$scope.getAllTranslations();
	$scope.getAllQuestionPosts();
	$scope.getAllCourses();
    $scope.getFooterContent();

}]);
