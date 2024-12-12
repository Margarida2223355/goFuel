package com.example.gofuel.modelView.Station;

import android.util.Log;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.station.StationRepository;
import com.example.gofuel.util.State;

import java.util.List;

public class StationViewModel extends ViewModel {
    private final StationRepository stationRepository;
    private final MutableLiveData<State> state = new MutableLiveData<>();

    public StationViewModel() {
        stationRepository = StationRepository.getInstance(MyApplication.getAppContext());
    }

    public MutableLiveData<State> getState() {
        return state;
    }

    public void loadStations() {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<Station>> result = stationRepository.getStations();

            if (result.getResult() != null) {
                state.postValue(new State.StationList(result.getResult()));
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
}
