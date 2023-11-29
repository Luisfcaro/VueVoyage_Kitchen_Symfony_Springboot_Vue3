package com.sboot.controller;

import com.sboot.model.Restaurants;
import com.sboot.service.RestaurantsService;
import com.sboot.repository.RestaurantsRepository;
import com.sboot.dto.RestaurantDTO;
import com.sboot.model.Categories;
import com.sboot.dto.CategoryDTO;


import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import org.springframework.http.ResponseEntity;
import org.springframework.http.HttpStatus;

import java.util.List;
import java.util.Optional;
import java.util.ArrayList;
import java.util.stream.Collectors;
import java.util.HashSet;
import java.util.Arrays;


@CrossOrigin(origins = "*")
@RestController
@RequestMapping(path = "restaurants")
public class RestaurantsController {

    @Autowired
    private RestaurantsService restaurantsService;

    @GetMapping
	public ResponseEntity<?> getAllRestaurants() {
		try {
			List<Restaurants> restaurants = new ArrayList<Restaurants>();
			restaurantsService.getRestaurants().forEach(restaurants::add);
			// restaurantsService.getRestaurants();
			return new ResponseEntity<>(restaurants, HttpStatus.OK);
		} catch (Exception e) {
			return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("Error buscando los restaurantes " + e.getMessage());
		}
	}


    @GetMapping("/{restaurantId}")
	public ResponseEntity<Restaurants> getRestaurantById(@PathVariable("restaurantId") long id) {
		Optional<Restaurants> restaurantData = restaurantsService.getTable(id);

		if (restaurantData.isPresent()) {
			return new ResponseEntity<>(restaurantData.get(), HttpStatus.OK);
		} else {
			return new ResponseEntity<>(HttpStatus.NOT_FOUND);
		}
	}

    


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // @GetMapping("/{restaurantId}/categories")
    // public ResponseEntity<RestaurantDTO> getRestaurantById(@PathVariable("restaurantId") Long id) {
    //     Optional<Restaurants> restaurant = restaurantsService.getTable(id);
    //     if (!restaurant.isPresent()) {
    //         return ResponseEntity.notFound().build();
    //     }

    //     List<CategoryDTO> categories = restaurantsService.getRestaurantCategories(id);
    //     RestaurantDTO restaurantDTO = convertToDTO(restaurant.get(), categories);
    //     return ResponseEntity.ok(restaurantDTO);
    // }

    // private RestaurantDTO convertToDTO(Restaurants restaurant, List<CategoryDTO> categories) {
    //     RestaurantDTO dto = new RestaurantDTO();
    //     dto.setId_rest(restaurant.getId().toString());
    //     dto.setName(restaurant.getName());
    //     dto.setImg_restaurant(restaurant.getImg());
    //     dto.setLocation(restaurant.getLocation());
    //     dto.setCategories(categories);

    //     return dto;
    // }


    
}