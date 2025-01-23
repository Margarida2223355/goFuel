package com.example.gofuel.view.fragments;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import com.example.gofuel.MyApplication;
import com.example.gofuel.R;
import com.example.gofuel.databinding.FragmentCartBinding;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.model.invoice.invoiceline.InvoicelinePost;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.modelView.Invoice.InvoiceViewModel;
import com.example.gofuel.modelView.Invoiceline.InvoicelineAdapter;
import com.example.gofuel.modelView.Invoiceline.InvoicelineViewModel;
import com.example.gofuel.util.State;
import com.example.gofuel.util.callback.InvoiceClose;
import com.example.gofuel.util.callback.OnCheckedBox;
import com.example.gofuel.util.callback.OnItemQtyChange;

import java.lang.reflect.Array;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;

public class CartFragment extends Fragment {
    private FragmentCartBinding binding;
    private Invoice invoice;
    private InvoicelineViewModel viewModel;
    private InvoiceViewModel invoiceViewModel;
    private ArrayList<InvoiceLine> linesToRemove;

    public CartFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentCartBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        viewModel = new ViewModelProvider(this).get(InvoicelineViewModel.class);
        invoiceViewModel = new ViewModelProvider(this).get(InvoiceViewModel.class);
        linesToRemove = new ArrayList<>();

        viewModel.getState().observe(getViewLifecycleOwner(), state -> {
            if (state instanceof State.Loading) {
                binding.linesList.setVisibility(View.GONE);
                binding.totalCard.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.loading.setVisibility(View.VISIBLE);
            }
            else if (state instanceof State.InvoiceLines) {
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.linesList.setVisibility(View.VISIBLE);
                binding.totalCard.setVisibility(View.VISIBLE);
                ArrayList<InvoiceLine> lines = new ArrayList<>(((State.InvoiceLines) state).getInvoiceLines());
                Double total = lines
                        .stream()
                        .mapToDouble(InvoiceLine::getTotal)
                        .sum();
                binding.linesList.setAdapter(new InvoicelineAdapter(getContext(), lines, new OnCheckedBox() {
                    @Override
                    public void onChecked(InvoiceLine line) {
                        linesToRemove.add(line);
                    }

                    @Override
                    public void onUnchecked(InvoiceLine line) {
                        linesToRemove.remove(line);
                    }
                }, new OnItemQtyChange() {
                    @Override
                    public void onQtyChanged(Boolean show) {}

                    @Override
                    public void changeQty(StationItem item, int qty) {}

                    @Override
                    public void onUpdateQty(InvoiceLine line) {
                        viewModel.updateLines(line, new InvoicelinePost(line.getItem().getId(), line.getQty(), (float) line.getTotal(), line.getInvoice().getId()));
                    }
                }));
                binding.totalValue.setText(String.format("%.2f", total) + "€");
            }
            else if (state instanceof State.EmptyState) {
                binding.loading.setVisibility(View.GONE);
                binding.linesList.setVisibility(View.GONE);
                binding.totalCard.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.VISIBLE);
            }
        });

        binding.removeBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (!linesToRemove.isEmpty()) { viewModel.removeLines(linesToRemove); }
                //Toast.makeText(getContext(), linesToChange.size() + " lines removed", Toast.LENGTH_SHORT).show();
            }
        });

        binding.payButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                invoiceViewModel.closeInvoice(invoice, new InvoiceClose() {
                    @Override
                    public void onSuccess() {
                        AppCompatActivity activity = (AppCompatActivity) view.getContext();
                                activity.getSupportFragmentManager()
                                        .beginTransaction()
                                        .replace(R.id.fragment, new InvoiceFragment())
                                        .addToBackStack(null)
                                        .commit();
                        Log.i("-->", "Success");
                    }

                    @Override
                    public void onError(String error) {
                        getActivity().runOnUiThread(() -> {
                            Toast.makeText(getActivity(), "Sem conexão com a internet. Verifique sua rede e tente novamente!", Toast.LENGTH_SHORT).show();
                        });
                        Log.i("-->", "Error: " + error);
                    }
                });
                //Toast.makeText(getContext(), "Pay", Toast.LENGTH_SHORT).show();
            }
        });

        viewModel.loadLines(invoice);

        return view;
    }

    public void setInvoice(Invoice invoice) {
        this.invoice = invoice;
    }
}