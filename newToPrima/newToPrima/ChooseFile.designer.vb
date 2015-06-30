<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ChooseFile
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.BtnImport = New System.Windows.Forms.Button()
        Me.Btnchoosefile = New System.Windows.Forms.Button()
        Me.OFDChooseFile = New System.Windows.Forms.OpenFileDialog()
        Me.TBxUrlFile = New System.Windows.Forms.TextBox()
        Me.SuspendLayout()
        '
        'BtnImport
        '
        Me.BtnImport.Location = New System.Drawing.Point(105, 111)
        Me.BtnImport.Name = "BtnImport"
        Me.BtnImport.Size = New System.Drawing.Size(75, 23)
        Me.BtnImport.TabIndex = 0
        Me.BtnImport.Text = "Importar"
        Me.BtnImport.UseVisualStyleBackColor = True
        '
        'Btnchoosefile
        '
        Me.Btnchoosefile.Location = New System.Drawing.Point(70, 27)
        Me.Btnchoosefile.Name = "Btnchoosefile"
        Me.Btnchoosefile.Size = New System.Drawing.Size(148, 23)
        Me.Btnchoosefile.TabIndex = 1
        Me.Btnchoosefile.Text = "Escolher Ficheiro "".txt"""
        Me.Btnchoosefile.UseVisualStyleBackColor = True
        '
        'OFDChooseFile
        '
        Me.OFDChooseFile.FileName = "OpenFileDialog1"
        '
        'TBxUrlFile
        '
        Me.TBxUrlFile.Location = New System.Drawing.Point(12, 65)
        Me.TBxUrlFile.Name = "TBxUrlFile"
        Me.TBxUrlFile.Size = New System.Drawing.Size(268, 20)
        Me.TBxUrlFile.TabIndex = 2
        '
        'ChooseFile
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(292, 151)
        Me.Controls.Add(Me.TBxUrlFile)
        Me.Controls.Add(Me.Btnchoosefile)
        Me.Controls.Add(Me.BtnImport)
        Me.Name = "ChooseFile"
        Me.Text = "ChooseFile"
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents BtnImport As System.Windows.Forms.Button
    Friend WithEvents Btnchoosefile As System.Windows.Forms.Button
    Friend WithEvents OFDChooseFile As System.Windows.Forms.OpenFileDialog
    Friend WithEvents TBxUrlFile As System.Windows.Forms.TextBox
End Class
