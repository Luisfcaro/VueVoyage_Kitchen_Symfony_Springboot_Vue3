package com.sboot.repository;

import com.sboot.model.Restaurants;
import com.sboot.model.Categories;
import com.sboot.dto.CategoryDTO;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;
import org.springframework.data.repository.query.Param;
import java.util.Optional;
import java.util.List;



@Repository
public interface RestaurantsRepository extends JpaRepository<Restaurants, Long> {
    // @Query(value = "SELECT rc.id_cat, c.name_cat, rc.desc_rest_cat FROM rest_cat rc, categories c WHERE rc.id_rest = :restaurantId AND rc.id_cat = c.id_cat;", nativeQuery = true)
    // List<CategoryDTO> getRestaurantCategories(@Param("restaurantId") Long restaurantId);

    @Query(value = "SELECT * FROM restaurant", nativeQuery = true)
    List<Restaurants> getAllRestaurants();

}






