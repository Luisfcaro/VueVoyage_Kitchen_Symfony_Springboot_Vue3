package com.sboot.service;

import com.sboot.model.Restaurants;
import com.sboot.repository.RestaurantsRepository;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class RestaurantsService {
    @Autowired
    RestaurantsRepository restaurantsRepository;

    public List<Restaurants> getRestaurants( String[] categories, String name_rest, Integer limit, Integer page, Integer order){

        name_rest = '%' + name_rest + '%'; 

        page = (page == null) ? 1 : page;
        limit = (limit == null) ? 3 : limit;
        order = (order == null) ? 1 : order;

        Integer offset = (page - 1) * limit;
        
        // Si no hay categorías proporcionadas, podrías querer retornar todos los restaurantes o una lista vacía aplicando el resto de filtros
        if (categories == null || categories.length == 0) {

            if (order == 1) {
                return restaurantsRepository.getAllRestaurantsAsc(name_rest, limit, offset);
            } else {
                return restaurantsRepository.getAllRestaurantsDesc(name_rest, limit, offset);
            }
        }

        // Si aplicamos todos los filtros
        if (order == 1) {
            return restaurantsRepository.getRestaurantsFilterAsc(categories, name_rest, limit, offset);
        } else {
            return restaurantsRepository.getRestaurantsFilterDesc(categories, name_rest, limit, offset);
        }

    }

    public Integer getRestaurantsPaginate( String[] categories, String name_rest, Integer limit, Integer page){

        name_rest = '%' + name_rest + '%'; 

        page = (page == null) ? 1 : page;
        limit = (limit == null) ? 3 : limit;

        Integer offset = (page - 1) * limit;
       
        if (categories == null || categories.length == 0) {

            return restaurantsRepository.getCountAllRestaurants(name_rest, limit, offset);

        }

        return restaurantsRepository.getCountRestaurantsFilter(categories, name_rest, limit, offset);

    }

    public List<Restaurants> getInfiniteScrollRestaurants(Integer limit){

        limit = (limit == null) ? 3 : limit;

        return restaurantsRepository.getInfiniteScrollRestaurants(limit);

    }

    public Optional<Restaurants> getTable(Long id){
        return restaurantsRepository.findById(id);
    }

    ////////////////////////////////////////////////

    // public List<CategoryDTO> getRestaurantCategories(Long id){
    //     return restaurantsRepository.getRestaurantCategories(id);
    // }
}