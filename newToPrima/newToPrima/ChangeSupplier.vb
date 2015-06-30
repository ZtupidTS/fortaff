Public Class ChangeSupplier

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click

        Try

            Dim motor As ErpBS800.ErpBS
            motor = New ErpBS800.ErpBS()
            'abre a empresa
            motor.AbreEmpresaTrabalho(StdBE800.EnumTipoPlataforma.tpProfissional, "FAFEDIS", "User", "1")

            SupplierPrima.getListSupplier(motor)
        Catch ex As Exception
            MsgBox(ex.Message)
        End Try

        MsgBox("Sucesso")

    End Sub

    
End Class