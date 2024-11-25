package com.example.gofuel.modelView.Main;

import android.util.Log;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.repository.client_station.ClientStationRepository;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoice.InvoiceRepository;
import com.example.gofuel.repository.station.StationRepository;
import com.example.gofuel.util.State;

import java.util.List;

public class MainViewModel extends ViewModel {
    private final ClientStationRepository clientStationRepository;
    private InvoiceRepository invoiceRepository;
    private final MutableLiveData<State> state = new MutableLiveData<>();

    public MainViewModel() {
        clientStationRepository = ClientStationRepository.getInstance(MyApplication.getAppContext());
        invoiceRepository = InvoiceRepository.getInstance(MyApplication.getAppContext());
    }

    public MutableLiveData<State> getState() {
        return state;
    }

    public void loadFavoriteStation() {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<ClientStation>> result = clientStationRepository.getFavoriteStation();

            if (result.getResult() != null) {
                state.postValue(new State.FavoriteStation(result.getResult()));
            } else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.FavoriteStation(null));
            }
        }).start();
    }

    public void loadPendingInvoices() {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<PendingInvoice>> result = invoiceRepository.getPendingInvoices();

            if (result.getResult() != null) {
                state.postValue(new State.PendingInvoiceList(result.getResult()));
            } else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.PendingInvoiceList(null));
            }
        }).start();
    }

    public void loadFinishedInvoices() {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<FinishedInvoice>> result = invoiceRepository.getFinishedInvoices();

            if (result.getResult() != null) {
                state.postValue(new State.FinishedInvoiceList(result.getResult()));
            } else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.FinishedInvoiceList(null));
            }
        }).start();
    }
}
