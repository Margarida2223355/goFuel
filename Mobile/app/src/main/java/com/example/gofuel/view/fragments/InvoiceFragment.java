package com.example.gofuel.view.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.gofuel.databinding.FragmentInvoiceBinding;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.modelView.Invoice.InvoiceAdapter;
import com.example.gofuel.modelView.Invoice.InvoiceViewModel;
import com.example.gofuel.util.State;

import java.util.ArrayList;

public class InvoiceFragment extends Fragment {

    private FragmentInvoiceBinding binding;
    private InvoiceViewModel viewModel;

    public InvoiceFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentInvoiceBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        viewModel = new ViewModelProvider(this).get(InvoiceViewModel.class);

        viewModel.getState().observe(getViewLifecycleOwner(), state -> {
            if (state instanceof State.Loading) {
                binding.invoiceList.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.noInternet.setVisibility(View.GONE);
                binding.loading.setVisibility(View.VISIBLE);
            }
            else if (state instanceof State.PendingInvoiceList) {
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.noInternet.setVisibility(View.GONE);
                binding.invoiceList.setVisibility(View.VISIBLE);
                ArrayList<PendingInvoice> invoices = new ArrayList<>(((State.PendingInvoiceList) state).getInvoices());
                binding.invoiceList.setAdapter(new InvoiceAdapter(getContext(), invoices));
            }

            else if (state instanceof State.EmptyState){
                binding.invoiceList.setVisibility(View.GONE);
                binding.loading.setVisibility(View.GONE);
                binding.noInternet.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.VISIBLE);
            }

            else if (state instanceof State.NoInternet) {
                binding.invoiceList.setVisibility(View.GONE);
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.noInternet.setVisibility(View.VISIBLE);
            }
        });

        viewModel.loadPendingInvoices();

        return view;
    }
}