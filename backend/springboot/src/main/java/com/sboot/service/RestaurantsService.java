package com.sboot.service;

import com.sboot.model.Categories;
import com.sboot.model.Restaurants;
import com.sboot.repository.RestaurantsRepository;
import com.sboot.dto.CategoryDTO;

import jakarta.persistence.EntityNotFoundException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.http.ResponseEntity;

import java.util.List;
import java.util.Optional;

@Service
public class RestaurantsService {
    @Autowired
    RestaurantsRepository restaurantsRepository;

    public List<Restaurants> getRestaurants(){
        // return restaurantsRepository.findAll();
        return restaurantsRepository.getAllRestaurants();
    }

    public Optional<Restaurants> getTable(Long id){
        return restaurantsRepository.findById(id);
    }

    // public List<CategoryDTO> getRestaurantCategories(Long id){
    //     return restaurantsRepository.getRestaurantCategories(id);
    // }
}