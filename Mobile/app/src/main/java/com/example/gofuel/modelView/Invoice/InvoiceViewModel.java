package com.example.gofuel.modelView.Invoice;

import android.util.Log;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.InvoicePost;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoice.InvoiceRepository;
import com.example.gofuel.util.State;
import com.example.gofuel.util.callback.InvoiceClose;
import com.example.gofuel.util.callback.InvoiceCreate;

import java.util.List;

public class InvoiceViewModel extends ViewModel {
    private final InvoiceRepository invoiceRepository;
    private final MutableLiveData<State> state = new MutableLiveData<>();

    public InvoiceViewModel() {
        invoiceRepository = InvoiceRepository.getInstance(MyApplication.getAppContext());
    }

    public MutableLiveData<State> getState() {
        return state;
    }

    public void loadPendingInvoices() {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<PendingInvoice>> result = invoiceRepository.getPendingInvoices();

            if (result.getResult() != null) {
                state.postValue(new State.PendingInvoiceList(result.getResult()));
            }
            else if (result.getError() != null) {
                state.postValue(new State.EmptyState());
            } else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.NoInternet());
            }
        }).start();
    }

    public void createInvoice(InvoicePost invoicePost, InvoiceCreate callback) {
        new Thread(() -> {
            ResultWrapper<PendingInvoice> result = invoiceRepository.addInvoice(invoicePost);

            if (result.getResult() != null) {
                callback.onSuccess(result.getResult());
            }
            else if (result.getError() != null) {
                callback.onError(result.getError());
            }
        }).start();
    }

    public void closeInvoice(Invoice invoice, InvoiceClose callback) {
        new Thread(() -> {
            ResultWrapper<String> result = invoiceRepository.closeInvoice(invoice);

            if (result.getResult() != null) {
                callback.onSuccess();
            } else if (result.getError() != null) {
                callback.onError(result.getError());
            }
        }).start();
    }
}
