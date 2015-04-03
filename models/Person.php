<?php 
class Person {
	public $jsonLD= array();

	/**
	 * get a Person By Id
	 * @param type $id : is the mongoId of the person
	 * @return type
	 */
	public static function getById($id) {
	  	$person = PHDB::findOne( PHType::TYPE_CITOYEN ,array("_id"=>new MongoId($id)));
	  	
	  	if (empty($person)) {
	  		//TODO Sylvain - Find a way to manage inconsistente data
            //throw new CommunecterException("The person id ".$id." is unkown : contact your admin");
        } else {
			$person["publicURL"] = '/person/public/id/'.$id;
        }

	  	return $person;
	}

	public static function setNameByid($name, $id) {
		PHDB::update(PHType::TYPE_CITOYEN,
			array("_id" => new MongoId($id)),
            array('$set' => array("name"=> $name))
            );
	}

	/**
	 * get all organizations details of a Person By a person Id
	 * @param type $id : is the mongoId (String) of the person
	 * @return person document as in db
	 */
	public static function getOrganizationsById($id){
		$person = Person::getById($id);
	    //$person["tags"] = Tags::filterAndSaveNewTags($person["tags"]);
	    $organizations = array();
	    
	    //Load organizations
	    if (isset($person["links"]) && !empty($person["links"]["memberOf"])) 
	    {
	      foreach ($person["links"]["memberOf"] as $id => $e) 
	      {
	        $organization = PHDB::findOne( PHType::TYPE_ORGANIZATIONS, array( "_id" => new MongoId($id)));
	        if (!empty($organization)) {
	          array_push($organizations, $organization);
	        } else {
	         // throw new CommunecterException("Données inconsistentes pour le citoyen : ".Yii::app()->session["userId"]);
	        }
	      }
	    }
	    return $organizations;
	}
	/**
	 * get memberOf a Person By a person Id
	 * @param type $id : is the mongoId (String) of the person
	 * @return person document as in db
	 */
	public static function getPersonMemberOfByPersonId($id) {
	  	$res = array();
	  	$person = Person::getById($id);
	  	
	  	if (empty($person)) {
            throw new CommunecterException("The person id is unkown : contact your admin");
        }
	  	if (isset($person) && isset($person["links"]) && isset($person["links"]["memberOf"])) {
	  		$res = $person["links"]["memberOf"];
	  	}

	  	return $res;
	}

	/**
	 * Happens when a Person is invited or linked as a member and doesn't exist in the system
	 * It is created in a temporary state
	 * This creates and invites the email to fill extra information 
	 * into the Person profile 
	 * @param type $param 
	 * @return type
	 */
	public static function createAndInvite($param) {
	  	Person::insert($param);

        //TODO TIB : mail Notification 
        //for the organisation owner to subscribe to the network 
        //and complete the Organisation Profile
	}

	/**
	 * Insert a new person from the minimal information inside the parameter
	 * @param array $person Minimal information to create a person ( 'name', 'email', 'postalCode', 'password')
	 * @return array result, msg and id
	 */
	public static function insert($person) {
	  	//Add aditional information
	  	$person["tobeactivated"] = true;
	  	$person["created"] = time();

	  	//Check if the email of the person is already in the database
	  	$account = PHDB::findOne(PHType::TYPE_CITOYEN,array("email"=>$person["email"]));
	  	if ($account) {
	  		throw new CommunecterException("Problem inserting the new person : a person with this email already exists in the plateform");
	  	}

	  	PHDB::insert( PHType::TYPE_CITOYEN , $person);
 
        if (isset($person["_id"])) {
	    	$newpersonId = (String) $person["_id"];
	    } else {
	    	throw new CommunecterException("Problem inserting the new person");
	    }

	    return array("result"=>true, "msg"=>"Une nouvelle personne est communectée.", "id"=>$newpersonId); 
	}

	/**
	 * Get a person from an id and return filter data in order to return only public data
	 * @param type $id 
	 * @return person
	 */
	public static function getPublicData($id) {
		//Public datas 
		$publicData = array (
			"imagePath",
			"name",
			"city",
			"socialAccounts",
			"positions",
			"url",
			"coi"
		);
		/*Photo de profil
		Centre d’intérêts
		Projets publics auxquels participe l’utilisateur
		Actualité publique
		Agenda public
		Réseau (cartographie)*/

		//TODO SBAR = filter data to retrieve only publi data	
		$person = Person::getById($id);
		if (empty($person)) {
			throw new CommunecterException("The person id is unknown ! Check your URL");
		}

		return $person;
	}

 	/**
		 * get all events details of a Person By a person Id
		 * @param type $id : is the mongoId (String) of the person
		 * @return person document as in db
	*/
	public static function getEventsByPersonId($id){
		$person = Person::getById($id);
	    $events = array();
	    
	    //Load events
	    if (isset($person["links"]) && !empty($person["links"]["events"])) 
	    {
	      foreach ($person["links"]["events"] as $id => $e) 
	      {
	        $event = PHDB::findOne( PHType::TYPE_EVENTS, array( "_id" => new MongoId($id)));
	        if (!empty($event)) {
	          array_push($events, $event);
	        } else {
	         // throw new CommunecterException("Données inconsistentes pour le citoyen : ".Yii::app()->session["userId"]);
	        }
	      }
	    }
	    return $events;
	} 


	/**
		* get person Data => need to update
		* @param type $id : is the mongoId (String) of the person
		* @return a map with : Person's informations, his organizations, events,projects
	*/
	public static function getPersonMap($id){
		$person = Person::getById($id);
		$organizations = Person::getOrganizationsById($id);
		$events = Person::getEventsByPersonId($id);
		$personMap = array(
							"person" => $person,
							"organizations" => $organizations,
							"events" => $events
						);
		return $personMap;
	}
}
?>