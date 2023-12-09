package com.sboot.repository;

import com.sboot.model.Restaurants;
import com.sboot.model.Categories;
import com.sboot.dto.CategoryDTO;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import java.util.Optional;
import java.util.List;



@Repository
public interface RestaurantsRepository extends JpaRepository<Restaurants, Long> {
    // @Query(value = "SELECT rc.id_cat, c.name_cat, rc.desc_rest_cat FROM rest_cat rc, categories c WHERE rc.id_rest = :restaurantId AND rc.id_cat = c.id_cat;", nativeQuery = true)
    // List<CategoryDTO> getRestaurantCategories(@Param("restaurantId") Long restaurantId);


    @Query(value = "SELECT * FROM restaurant r WHERE r.name_rest LIKE :name_rest ORDER BY r.name_rest ASC LIMIT :limit OFFSET :offset", nativeQuery = true)
    List<Restaurants> getAllRestaurantsAsc(@Param("name_rest") String name_rest, @Param("limit") Integer limit, @Param("offset") Integer offset);

    @Query(value = "SELECT * FROM restaurant r WHERE r.name_rest LIKE :name_rest ORDER BY r.name_rest DESC LIMIT :limit OFFSET :offset", nativeQuery = true)
    List<Restaurants> getAllRestaurantsDesc(@Param("name_rest") String name_rest, @Param("limit") Integer limit, @Param("offset") Integer offset);

    ////////////////////////////////////////////////////////////////

    @Query(value = "SELECT * FROM restaurant r WHERE r.id IN (SELECT restaurant_id FROM restaurant_category WHERE category_id IN (:categories)) AND r.name_rest LIKE :name_rest ORDER BY r.name_rest ASC LIMIT :limit OFFSET :offset", nativeQuery = true)
    List<Restaurants> getRestaurantsFilterAsc(@Param("categories") String[] categories, @Param("name_rest") String name_rest, @Param("limit") Integer limit, @Param("offset") Integer offset);

    @Query(value = "SELECT * FROM restaurant r WHERE r.id IN (SELECT restaurant_id FROM restaurant_category WHERE category_id IN (:categories)) AND r.name_rest LIKE :name_rest ORDER BY r.name_rest DESC LIMIT :limit OFFSET :offset", nativeQuery = true)
    List<Restaurants> getRestaurantsFilterDesc(@Param("categories") String[] categories, @Param("name_rest") String name_rest, @Param("limit") Integer limit, @Param("offset") Integer offset);

    ////////////////////////////////////////////////////////////////

    @Query(value = "SELECT COUNT(*) FROM restaurant r WHERE r.name_rest LIKE :name_rest LIMIT :limit OFFSET :offset", nativeQuery = true)
    Integer getCountAllRestaurants(@Param("name_rest") String name_rest, @Param("limit") Integer limit, @Param("offset") Integer offset);

    @Query(value = "SELECT COUNT(*) FROM restaurant r WHERE r.id IN (SELECT restaurant_id FROM restaurant_category WHERE category_id IN (:categories)) AND r.name_rest LIKE :name_rest LIMIT :limit OFFSET :offset", nativeQuery = true)
    Integer getCountRestaurantsFilter(@Param("categories") String[] categories, @Param("name_rest") String name_rest, @Param("limit") Integer limit, @Param("offset") Integer offset);

    ////////////////////////////////////////////////////////////////


    @Query(value = "SELECT * FROM restaurant r ORDER BY r.name_rest ASC LIMIT :limit", nativeQuery = true)
    List<Restaurants> getInfiniteScrollRestaurants(@Param("limit") Integer limit);

}






