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
import java.util.List;
import java.util.stream.Collectors;

public class ItemViewModel extends ViewModel {
    private final StationItemRepository stationItemRepository;
    private final MutableLiveData<State> state = new MutableLiveData<>();
    private ArrayList<StationItem> items;

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
                state.postValue(new State.StationItemList(result.getResult()));
                items = new ArrayList<>(result.getResult());
            }
            else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.EmptyState());
            }
        }).start();
    }

    public void getItemsByCategoryDescription(String text) {
        state.setValue(new State.Loading());

        List<StationItem> itemsCategory = items.stream()
                .filter( item -> {
                    String categoryName = item.getItem().getSubcategory().getCategory().getName().toLowerCase();
                    String description = item.getItem().getDescription().toLowerCase();
                    return
                            categoryName.contains(text.toLowerCase()) || description.contains(text.toLowerCase());
                })
                .collect(Collectors.toList());

        state.setValue(new State.StationItemList(itemsCategory));
    }
}
