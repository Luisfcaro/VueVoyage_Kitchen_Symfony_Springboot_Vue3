package com.sboot.controller;

import com.sboot.model.Bookings;
import com.sboot.model.Restaurants;
import com.sboot.model.Turns;
import com.sboot.model.User;
import com.sboot.repository.BookingsRepository;
import com.sboot.repository.RestaurantsRepository;
import com.sboot.repository.TurnsRepository;
import com.sboot.repository.UserRepository;
import com.sboot.service.TurnsService;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping(path = "bookings")
public class BookingsController {

  @Autowired
  private TurnsService turnsService;

  @Autowired
  private BookingsRepository bookingsRepository;

  @Autowired
  private UserRepository UserRepository;

  @Autowired
  private TurnsRepository turnsRepository;

  @Autowired
  private RestaurantsRepository restaurantsRepository;

  @GetMapping("")
  public ResponseEntity<List<Bookings>> getBookings() {
    try {
      UserDetails userDetails = (UserDetails) SecurityContextHolder
        .getContext()
        .getAuthentication()
        .getPrincipal();
      User user = UserRepository
        .findByUsername(userDetails.getUsername())
        .get();

      List<Bookings> userBookings = bookingsRepository.findByUserId(
        user.getId()
      );

      return new ResponseEntity<>(userBookings, HttpStatus.OK);
    } catch (Exception e) {
      System.out.println("Error en el controlador: ");
      e.printStackTrace();
      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
    }
  }

  @PostMapping("/checkDateAndCapacity")
  public ResponseEntity<List<Turns>> checkDateAndCapacity(
    @RequestBody Map<String, Object> body
  ) {
    try {
      int people = (int) body.get("people");
      String date_pick = (String) body.get("date");
      int rest = (int) body.get("rest");

      List<Turns> turns = new ArrayList<Turns>();
      turnsService
        .getTurnsAvaibles(people, date_pick, rest)
        .forEach(turns::add);
      return new ResponseEntity<>(turns, HttpStatus.OK);
    } catch (Exception e) {
      System.out.println("Error en el controlador: ");
      e.printStackTrace();
      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
    }
  }

  @PostMapping("/makeReservation")
  public ResponseEntity<String> postMethodName(
    @RequestBody Map<String, Object> body
  ) {
    try {
      int people = (int) body.get("people");
      String date_pick = (String) body.get("date");

      // Check and cast rest and shift appropriately
      Long rest = null;
      Long shift = null;

      Object restObj = body.get("rest");
      Object shiftObj = body.get("shift");

      if (restObj instanceof Integer) {
        rest = ((Integer) restObj).longValue();
      } else if (restObj instanceof Long) {
        rest = (Long) restObj;
      }

      if (shiftObj instanceof Integer) {
        shift = ((Integer) shiftObj).longValue();
      } else if (shiftObj instanceof Long) {
        shift = (Long) shiftObj;
      }

      UserDetails userDetails = (UserDetails) SecurityContextHolder
        .getContext()
        .getAuthentication()
        .getPrincipal();
      User user = UserRepository
        .findByUsername(userDetails.getUsername())
        .get();

      Turns turn = turnsRepository.findById(shift).get();
      Restaurants restaurant = restaurantsRepository.findById(rest).get();

      Bookings booking = new Bookings();

      booking.setUser(user);
      booking.setRestaurant(restaurant);
      booking.setTurns(turn);
      booking.setPeople(people);
      booking.setState("Pendiente");
      booking.setDate(date_pick);

      bookingsRepository.save(booking);

      return new ResponseEntity<>(HttpStatus.OK);
    } catch (Exception e) {
      System.out.println("Error en el controlador: ");
      e.printStackTrace();
      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
    }
  }

  @PutMapping("/cancel/{bookingId}")
  public ResponseEntity<String> cancelReservation(
    @PathVariable Long bookingId
  ) {
    try {
      Bookings booking = bookingsRepository.findById(bookingId).orElse(null);

      if (booking == null) {
        return new ResponseEntity<>(
          "Reserva no encontrada",
          HttpStatus.NOT_FOUND
        );
      }

      booking.setState("Cancelada");
      bookingsRepository.save(booking);

      return new ResponseEntity<>(
        "Reserva cancelada exitosamente",
        HttpStatus.OK
      );
    } catch (Exception e) {
      System.out.println("Error en el controlador: ");
      e.printStackTrace();
      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
    }
  }
}
