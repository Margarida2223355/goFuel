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

import java.util.ArrayList;
import java.util.HashMap;
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

    public void loadInfo() {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<ClientStation>> favoriteStation = clientStationRepository.getFavoriteStation();
            ResultWrapper<List<PendingInvoice>> pendingInvoices = invoiceRepository.getPendingInvoices();
            ResultWrapper<List<FinishedInvoice>> finishedInvoices = invoiceRepository.getFinishedInvoices();

            if ((favoriteStation.getError() == null) && (pendingInvoices.getError() == null) && (finishedInvoices.getError() == null)) {
                Double total = 0.0;
                HashMap<String, String> pendingValues = new HashMap<>();

                for (PendingInvoice invoice : pendingInvoices.getResult()) {
                    total += invoice.getTotal();
                }

                pendingValues.put("Nº Faturas", String.valueOf(pendingInvoices.getResult().size()));
                pendingValues.put("Valor Faturas [€]", String.valueOf(total));

                state.postValue(new State.MainResults(favoriteStation.getResult(), pendingValues, finishedInvoices.getResult()));
            }
            else {
                Log.e("-->", "Error API: " + favoriteStation.getError());
                Log.e("-->", "Error API: " + pendingInvoices.getError());
                Log.e("-->", "Error API: " + finishedInvoices.getError());
            }
        }).start();
    }
}
