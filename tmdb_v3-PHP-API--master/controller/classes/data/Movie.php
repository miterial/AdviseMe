<?php
/**
 * 	This class handles all the data you can get from a Movie
 *
 *	@package TMDB-V3-PHP-API
 * 	@author Alvaro Octal | <a href="https://twitter.com/Alvaro_Octal">Twitter</a>
 * 	@version 0.2
 * 	@date 02/04/2016
 * 	@link https://github.com/Alvaroctal/TMDB-PHP-API
 * 	@copyright Licensed under BSD (http://www.opensource.org/licenses/bsd-license.php)
 */
class Movie extends ApiBaseObject{

	private $_tmdb;

	//------------------------------------------------------------------------------
	// Get Variables
	//------------------------------------------------------------------------------
	/** 
	 * 	Get the Movie's status
	 *
	 * 	@return string
	 */
	public function getStatus() {
		return $this->_data['status'];
	}
	/** 
	 * 	Get the Movie's bg pic
	 *
	 * 	@return string
	 */
	public function getBackground() {
		return $this->_data['backdrop_path'];
	}
	/** 
	 * 	Get the Movie's title
	 *
	 * 	@return string
	 */
	public function getTitle() {
		return $this->_data['title'];
	}

	/** 
	 * 	Get the Movie's original title
	 *
	 * 	@return string
	 */
	public function getOriginalTitle() {
		return $this->_data['original_title'];
	}

	/** 
	 * 	Get the Movie's release date
	 *
	 * 	@return string
	 */
	public function getReleaseDate() {
		return $this->_data['release_date'];
	}
	/** 
	 * 	Get the Movie's summary
	 *
	 * 	@return string
	 */
	public function getOverview() {
		return $this->_data['overview'];
	}

	/** 
	 * 	Get the Movie's tagline
	 *
	 * 	@return string
	 */
	public function getTagline() {
		return $this->_data['tagline'];
	}

	/** 
	 * 	Get the Movie Directors IDs
	 *
	 * 	@return array(int)
	 */
	public function getDirectorNames() {

		$crew = $this->getDirectors();

		/*foreach ($crew as $crew_member) {

			if ($crew_member['job'] === 'Director'){
				$director_ids[] = $crew_member['id'];
			}
		}
		return $director_ids;*/
		return $crew;
	}

	/** 
	 * 	Get the Movie's trailers
	 *
	 * 	@return array
	 */
	public function getTrailers() {
		return $this->_data['trailers'];
	}

	/** 
	 * 	Get the Movie's trailer
	 *
	 * 	@return string
	 */
	public function getTrailer() {
		$trailers = $this->getTrailers();
		return $trailers['youtube'][0]['source'];
	}

	/** 
	 * 	Get the Movie's genres
	 *
	 * 	@return Genre[]
	 */
	public function getGenres() {
		$genres = array();

		foreach ($this->_data['genres'] as $data) {
			$genres[] = new Genre($data);
		}

		return $genres;
	}

	/** 
	 * 	Get the Movie's reviews
	 *
	 * 	@return Review[]
	 */
	public function getReviews() {
		$reviews = array();

		foreach ($this->_data['review']['result'] as $data) {
			$reviews[] = new Review($data);
		}

		return $reviews;
	}

	/**
	 * 	Get the Movie's companies
	 *
	 * 	@return Company[]
	 */
	public function getCompanies() {
		$companies = array();
		
		foreach ($this->_data['production_companies'] as $data) {
			$companies[] = new Company($data);
		}
		
		return $companies;
	}

	/** 
	 * 	Get the Movie production countries
	 *
	 * 	@return array(int)
	 */
	public function getMovieCountries() {
		$countries = [];

		foreach ($this->_data['production_countries'] as $data) {
			$el = new Company($data);
			$countries[] = $el->getName();
		}
		
		return $countries;
	}


	/**
	 * 	Get the Movie's IMDB iD
	 *
	 * 	@return string or null
	 */
	public function getImdbId() {
		return $this->_data['imdb_id'];
	}

	//------------------------------------------------------------------------------
	// Import an API instance
	//------------------------------------------------------------------------------

	/**
	 *	Set an instance of the API
	 *
	 *	@param TMDB $tmdb An instance of the api, necessary for the lazy load
	 */
	public function setAPI($tmdb){
		$this->_tmdb = $tmdb;
	}

	//------------------------------------------------------------------------------
	// Export
	//------------------------------------------------------------------------------

	/** 
	 * 	Get the JSON representation of the Movie
	 *
	 * 	@return string
	 */
	public function getJSON() {
		return json_encode($this->_data, JSON_PRETTY_PRINT);
	}


	/**
	 * @return string
	 */
	public function getMediaType(){
		return self::MEDIA_TYPE_MOVIE;
	}
}
