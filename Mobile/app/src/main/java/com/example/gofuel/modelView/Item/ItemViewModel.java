package com.example.gofuel.modelView.Item;

import android.util.Log;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.station.StationItem;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.station_item.StationItemRepository;
import com.example.gofuel.util.State;

import java.util.List;

public class ItemViewModel extends ViewModel {
    private final StationItemRepository stationItemRepository;
    private final MutableLiveData<State> state = new MutableLiveData<>();

    public ItemViewModel() {
        stationItemRepository = StationItemRepository.getInstance(MyApplication.getAppContext());
    }

    public MutableLiveData<State> getState() {
        return state;
    }

    public void loadItems() {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<StationItem>> result = stationItemRepository.getStationItems();

            if (result.getResult() != null) {
                state.postValue(new State.StationItemList(result.getResult()));
            }
            else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.EmptyState());
            }
        }).start();
    }
}
