package com.example.gofuel.modelView.Item;

import android.util.Log;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.station_item.StationItemRepository;
import com.example.gofuel.util.State;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;

public class ItemViewModel extends ViewModel {
    private final StationItemRepository stationItemRepository;
    private final MutableLiveData<State> state = new MutableLiveData<>();
    private HashMap<StationItem, Integer> items = new HashMap<>();
    private HashMap<StationItem, Integer> filteresItems = new HashMap<>();
    private Boolean categorySearch = false;

    public ItemViewModel() {
        stationItemRepository = StationItemRepository.getInstance(MyApplication.getAppContext());
    }

    public MutableLiveData<State> getState() {
        return state;
    }

    public void loadItems(Station station) {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<StationItem>> result = stationItemRepository.getStationItems(station);

            if (result.getResult() != null) {
                for (StationItem item : result.getResult()) {
                    items.put(item, 0);
                }

                state.postValue(new State.StationItemList(items));
            }
            else if (result.getError() != null) {
                state.postValue(new State.EmptyState());
            }
            else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.NoInternet());
            }
        }).start();
    }

    public void getItemsByCategoryDescription(String text) {
        categorySearch = !text.isEmpty();

        state.setValue(new State.Loading());

        filteresItems = items.entrySet().stream()
                .filter( item -> {
                    String categoryName = item.getKey().getItem().getSubcategory().getCategory().getName().toLowerCase();
                    String description = item.getKey().getItem().getDescription().toLowerCase();
                    return
                            categoryName.contains(text.toLowerCase()) || description.contains(text.toLowerCase());
                })
                .collect(Collectors.toMap(
                        Map.Entry::getKey,
                        Map.Entry::getValue,
                        (a, b) -> a,
                        HashMap::new
                ));

        state.setValue(new State.StationItemList(filteresItems));
    }

    public void updateItemsQty(StationItem item, int qty) {
        items.put(item, qty);

        if (categorySearch) {
            filteresItems.put(item, qty);
            state.setValue(new State.StationItemList(filteresItems));
        }
        else {
            state.setValue(new State.StationItemList(items));
        }
    }
}
